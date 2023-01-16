<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\PlaidController;
use App\Http\Requests\StoreSendReceiveDetails;
use App\Http\Requests\StoreRecipientDetails;
use App\Http\Requests\StoreSenderDetails;
use App\Http\Requests\StorePaymentDetails;
use App\Models\UserActivityDetails;
use App\Models\UserRecipientDetails;
use App\Models\UserSenderDetails;
use App\Models\UserPaymentDetails;
use Session;
use DB;
use App\Helpers\GlobalValues;
use App\Http\Controllers\ThunesController;
use App\Models\UserPaymentTransaction;
use App\Models\Payer;
use Piplmodules\ReceivingCountry\Models\ReceivingCountry;
use Piplmodules\Sendinglimits\Models\Sendinglimit;
use App\Models\UserSubscriptionAttr;
use App\Models\Otp;
use Carbon\Carbon;
use App\Jobs\SendEmailQueue;
use Mail;
use Piplmodules\Emailtemplates\Models\EmailTemplateTrans;


use Barryvdh\DomPDF\Facade as PDF;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Start send money page, step one.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function sendReceiveDetails(Request $request)
    {
        $user_id = Auth::user()->id;
        $selected_send_country = UserInformation::where(['user_informations.id' => $user_id])->leftJoin('payers', function ($join) {
            $join->on('payers.payer_country', '=', 'user_informations.send_money_to');
        })->first();

        if (empty($selected_send_country->payer_id)) {
            request()->session()->flash('alert-danger', 'Please set send country first');
            return redirect()->route('edit-profile');
        }

        $url = 'payers/' . $selected_send_country->payer_id . '/rates';
        $request_type = 'GET';
        $post_data = [];
        $res = GeneralHelper::thunesAPI($url, $request_type, $post_data);

        if(isset($res->errors)){
            request()->session()->flash('alert-danger', $res->errors[0]->message.', please contact administrator');
            return redirect()->route('edit-profile');
        }
    
        $current_rate = ($res) ? number_format($res->rates->C2C->USD[0]->wholesale_fx_rate, 2) : 0;

        $obj_plaid =  new PlaidController();
        $banks = []; //$obj_plaid->getInstitutions();
        session(['current_rate' => $current_rate]);

        $user_activity = UserActivityDetails::where(['user_id' => $user_id])->first();
        if (isset($user_activity)) {
            //$user_activity->delete();
        }

        $user_sender_details = UserSenderDetails::where(['user_id' => $user_id])->first();
        if (isset($user_sender_details)) {
            //$user_sender_details->delete();
        }

        $user_recipient_details = UserRecipientDetails::where(['user_id' => $user_id])->first();
        if (isset($user_recipient_details)) {
            //$user_recipient_details->delete();
        }

        $user_payment_details = UserPaymentDetails::where(['user_id' => $user_id])->first();
        if (isset($user_payment_details)) {
            //$user_payment_details->delete();
        }

        $request->session()->forget(['send_amount', 'receive_amount', 'bank_name', 'payment_method', 'bank_id', 'error_msg','start_over_selected_recipient']);

        $payers = Payer::where(['payer_country' => $selected_send_country->payer_country])->groupBy('payer_service')->get();
        //dd($payers);

        return view('payments.send-receive-details', compact('current_rate', 'banks', 'payers'));
    }

    public function getOneDayLimit()
    {
        $user_id = Auth::user()->id;
        $today = date('Y-m-d');
        return UserPaymentTransaction::where('user_id', $user_id)->whereDate('created_at', '=', $today)->groupBy("user_id")->sum('sent_amount');
    }

    /*
    * To save the receiver details into database for further processing.
    */
    public function saveSendReceiveDetails(StoreSendReceiveDetails $request)
    {
        $input = $request->all();
        $request->validated();
        $user_id = Auth::user()->id;
        $user_activity = UserActivityDetails::where(['user_id' => $user_id])->first();
        $send_amount = $request->send_amount;
        $receive_amount = $request->receive_amount;
        $bank_name = $request->bank_name;
        $payment_method = $request->payment_method;
        $receive_currency = $request->receive_currency;
        $receive_country = $request->receive_country;

        session(['send_amount' => $send_amount, 'receive_amount' => $receive_amount, 'bank_name' => explode("###", $bank_name)[0], 'payment_method' => explode("###", $payment_method)[0]]);

        $payer_id = explode("###", $payment_method)[1];
        $payer_details = Payer::where(['payer_id' => $payer_id])->first();

        if (empty($payer_details)) {
            return redirect()->route('send-receive-details')->with("alert-danger", "Invalid payer details");
        } else {
            if ($payer_details->min_amount > 0.0 && $receive_amount < $payer_details->min_amount) {
                return redirect()->route('send-receive-details')->with("alert-danger", "Receive amount should not be less than " . $payer_details->min_amount);
            } else if ($payer_details->max_amount && $receive_amount > $payer_details->max_amount) {
                return redirect()->route('send-receive-details')->with("alert-danger", "Receive amount should not be greated than " . $payer_details->max_amount);
            }
        }

        $sharedSendingLimit = UserSubscriptionAttr::where(['user_id' => $user_id])->orderBy('id', 'DESC')->first();

        $today = date('Y-m-d');

        $thirty_days = date('Y-m-d', strtotime($today . ' - 30 days'));
        $half_yearly = date('Y-m-d', strtotime($today . ' - 180 days'));

        $oneDayTotalAmountSent = UserPaymentTransaction::where('user_id', $user_id)->whereDate('created_at', '=', $today)->groupBy("user_id")->sum('sent_amount');

        $thirtyDaysTotalAmountSent = UserPaymentTransaction::where('user_id', $user_id)->whereDate('created_at', '>=', $thirty_days)->groupBy("user_id")->sum('sent_amount');

        $halfYearlyTotalAmountSent = UserPaymentTransaction::where('user_id', $user_id)->whereDate('created_at', '>=', $half_yearly)->groupBy("user_id")->sum('sent_amount');

        if(($sharedSendingLimit->one_day_price - $oneDayTotalAmountSent) < $send_amount ){
            return redirect()->route('send-receive-details')->with("alert-danger", "Receive amount should not be greater than " . ($sharedSendingLimit->one_day_price - $oneDayTotalAmountSent). " for 24 hours limit");
        }

        if(($sharedSendingLimit->thirty_day_price - $thirtyDaysTotalAmountSent) < $send_amount ){
            return redirect()->route('send-receive-details')->with("alert-danger", "Receive amount should not be greater than " .($sharedSendingLimit->thirty_day_price - $thirtyDaysTotalAmountSent). " for 30 days limit");
        }

        if(($sharedSendingLimit->half_yearly_price - $halfYearlyTotalAmountSent) < $send_amount ){
            return redirect()->route('send-receive-details')->with("alert-danger", "Receive amount should not be greater than " .($sharedSendingLimit->half_yearly_price - $halfYearlyTotalAmountSent). " for 180 days limit");
        }

        if ($user_activity) {
            $user_activity->send_amount = $send_amount;
            $user_activity->receive_amount = $receive_amount;
            $user_activity->bank_name = $bank_name;
            $user_activity->payment_method = $payment_method;
            $user_activity->receive_currency = $receive_currency;
            $user_activity->receive_country = $receive_country;
            $user_activity->step_to_complete = 2;
            $user_activity->save();
        } else {
            $user_activity = new UserActivityDetails();
            $user_activity->user_id = $user_id;
            $user_activity->send_amount = $send_amount;
            $user_activity->receive_amount = $receive_amount;
            $user_activity->bank_name = $bank_name;
            $user_activity->payment_method = $payment_method;
            $user_activity->receive_currency = $receive_currency;
            $user_activity->receive_country = $receive_country;
            $user_activity->step_to_complete = 2;
            $user_activity->save();
        }

        return redirect()->route('recipient-details');
    }

    public function recipientDetails()
    {
        $user_id = Auth::user()->id;
        $user_info = UserInformation::where(['user_id' => $user_id])->first();
        $country_detail = ReceivingCountry::where(['country_iso_code' => ($user_info->send_money_to) ? $user_info->send_money_to : 'MEX'])->first();
        
        $user_recipient_list = UserRecipientDetails::where(['user_id' => $user_id, 'country_code' => $country_detail->phone_code])->orderBy('id','desc')->get();
        $user_recipient_details = collect();
        $user_recipient_details->bank_account_no = "";
        
        if (session('start_over_selected_recipient') != null) {
            $user_recipient_details = UserRecipientDetails::where(['id' => session('start_over_selected_recipient')])->first();
        }elseif ($user_recipient_list->count() == 1) {
            $user_recipient_details = $user_recipient_list[0];
        }else{
            $user_recipient_details = new UserRecipientDetails();
            $user_recipient_details->bank_account_no = "";
            $user_recipient_details->first_name = "";
            $user_recipient_details->last_name = "";
            $user_recipient_details->phone_no = "";
            $user_recipient_details->address = "";
            $user_recipient_details->city = "";
            $user_recipient_details->state = "";
            $user_recipient_details->reason_for_sending = "";
        }
        
        $selected_send_country = UserInformation::where(['user_informations.id' => $user_id])->leftJoin('payers', function ($join) {
            $join->on('payers.payer_country', '=', 'user_informations.send_money_to');
        })->first();

        $country_phone_code = 52; // The default Mexico country code
        if (isset($selected_send_country)) {
            switch ($selected_send_country->payer_country) {
                case 'CRI':
                    $country_phone_code = 506;
                    break;
                case 'GTM':
                    $country_phone_code = 502;
                    break;
                case 'HTI':
                    $country_phone_code = 509;
                    break;
                case 'SLV':
                    $country_phone_code = 503;
                    break;
                default:
                    $country_phone_code = 52;
                    break;
            }
        }
        return view('payments.recipient-details', compact('user_recipient_list','user_recipient_details', 'country_phone_code'));
    }

    public function selectRecipient(Request $request){
        session(['start_over_selected_recipient' => $request->selecetd_recipient]);
        return redirect()->route('recipient-details');
    }

    /*
    * To save recipient details into database for further processing
    */
    public function saveRecipientDetails(StoreRecipientDetails $request)
    {
        $request->validated();

        $user_id = Auth::user()->id;

        $selected_send_country = UserInformation::where(['user_informations.id' => $user_id])->leftJoin('payers', function ($join) {
            $join->on('payers.payer_country', '=', 'user_informations.send_money_to');
        })->first();

        if (empty($selected_send_country->payer_id)) {
            request()->session()->flash('alert-danger', 'Please set send country first');
            return redirect()->route('edit-profile');
        }

        /*
        $user_activity_details = UserActivityDetails::where(['user_id' => $user_id])->first();
        //dd($user_activity_details);
        $user_recipient_details = UserRecipientDetails::where(['user_id' => $user_id])->first();

        $url = 'payers/' . explode('###', $user_activity_details->payment_method)[1] . '/C2C/credit-party-verification';
        $request_type = 'POST';

        if ($user_activity_details->receive_country == 'MEX' && explode("###", $user_activity_details->payment_method)[0] == 'BankAccount') {
            $credit_party_identifier =  [
                "clabe" => $request->bank_account_no
            ];
        }elseif ($user_activity_details->receive_country == 'CRI' && explode("###", $user_activity_details->payment_method)[0] == 'BankAccount') {
            $credit_party_identifier =  [
                "iban" => $request->bank_account_no
            ];
        } elseif (explode("###", $user_activity_details->payment_method)[0] == 'BankAccount') {
            $credit_party_identifier =  [
                "bank_account_number" => $request->bank_account_no
            ];
        } else {
            $credit_party_identifier =  [
                "msisdn" => $request->phone_no
            ];
        }

        $post_data = [
            "credit_party_identifier" => $credit_party_identifier,
        ];

        $res = GeneralHelper::thunesAPI($url, $request_type, $post_data);
        if(isset($res->errors)){
            
            $alert_type = 'alert-danger';
            //dd($res->errors[0]->message);
            $errorMsg = $res->errors[0]->message;
            request()->session()->flash($alert_type, $errorMsg);
            return back()->withInput()->withErrors($alert_type, $errorMsg);
        }*/

        $user_activity = UserActivityDetails::where(['user_id' => $user_id])->first();
        if ($user_activity) {
            $user_activity->step_to_complete = 3;
            $user_activity->save();
        }

        $user_recipient_details = UserRecipientDetails::where(['user_id' => $user_id])->first();

        if ($user_recipient_details) {
            $user_recipient_details->bank_account_no = $request->bank_account_no;
            $user_recipient_details->first_name = $request->first_name;
            $user_recipient_details->last_name = $request->last_name;
            $user_recipient_details->phone_no = $request->phone_no;
            $user_recipient_details->country_code = $request->phone_no_phoneCode;
            $user_recipient_details->address = $request->address;
            $user_recipient_details->city = $request->city;
            $user_recipient_details->state = $request->state;
            $user_recipient_details->reason_for_sending = $request->reason_for_sending;
            $user_recipient_details->save();
        } else {
            $user_recipient_details = new UserRecipientDetails();
            $user_recipient_details->user_id = $user_id;
            $user_recipient_details->bank_account_no = $request->bank_account_no;
            $user_recipient_details->first_name = $request->first_name;
            $user_recipient_details->last_name = $request->last_name;
            $user_recipient_details->phone_no = $request->phone_no;
            $user_recipient_details->country_code = $request->phone_no_phoneCode;
            $user_recipient_details->address = $request->address;
            $user_recipient_details->city = $request->city;
            $user_recipient_details->state = $request->state;
            $user_recipient_details->reason_for_sending = $request->reason_for_sending;
            $user_recipient_details->save();
        }
        return redirect()->route('sender-details');
    }

    /*
    * Fetch and display the sender details if already in database
    */
    public function senderDetails()
    {
        $user_id = Auth::user()->id;
        //$user_sender_details = UserSenderDetails::where(['user_id' => $user_id])->first();

        $user_sender_details = UserInformation::where(['user_id' => $user_id])->first();
        
        if (empty($user_sender_details)) {
            $user_sender_details = new UserSenderDetails();
            $user_sender_details->first_name = "";
            $user_sender_details->last_name = "";
            $user_sender_details->phone_no = "";
            $user_sender_details->address_line_1 = "";
            $user_sender_details->address_line_2 = "";
            $user_sender_details->state = "";
            $user_sender_details->city = "";
            $user_sender_details->zip_code = "";
            $user_sender_details->dob = "";
        }
        return view('payments.sender-details', compact('user_sender_details'));
    }

    /*
    * To save the sender details into database for further processing
    */
    public function saveSenderDetails(StoreSenderDetails $request)
    {
        $request->validated();

        $user_id = Auth::user()->id;
        $user_activity = UserActivityDetails::where(['user_id' => $user_id])->first();
        if ($user_activity) {
            $user_activity->step_to_complete = 4;
            $user_activity->save();
        }

        $user_sender_details = UserSenderDetails::where(['user_id' => $user_id])->first();

        if ($user_sender_details) {
            $user_sender_details->first_name = $request->first_name;
            $user_sender_details->last_name = $request->last_name;
            $user_sender_details->phone_no = $request->phone_no;
            $user_sender_details->country_code = $request->phone_no_phoneCode;
            $user_sender_details->address_line_1 = $request->address_line_1;
            $user_sender_details->address_line_2 = $request->address_line_2;
            $user_sender_details->state = $request->state;
            $user_sender_details->city = $request->city;
            $user_sender_details->zip_code = $request->zip_code;
            $user_sender_details->dob = date('Y-m-d', strtotime($request->dob));
            $user_sender_details->save();
        } else {
            $user_sender_details = new UserSenderDetails();
            $user_sender_details->user_id = $user_id;
            $user_sender_details->first_name = $request->first_name;
            $user_sender_details->last_name = $request->last_name;
            $user_sender_details->phone_no = $request->phone_no;
            $user_sender_details->country_code = $request->phone_no_phoneCode;
            $user_sender_details->address_line_1 = $request->address_line_1;
            $user_sender_details->address_line_2 = $request->address_line_2;
            $user_sender_details->state = $request->state;
            $user_sender_details->city = $request->city;
            $user_sender_details->zip_code = $request->zip_code;
            $user_sender_details->dob = date('Y-m-d', strtotime($request->dob));
            $user_sender_details->save();
        }
        return redirect()->route('payment-page');
    }

    /*
    * Fetch & display the payment information if already available
    */
    public function paymentPage()
    {
        $user_id = Auth::user()->id;
        $user_payment_details = UserPaymentDetails::where(['user_id' => $user_id])->first();        
        $user_address_details = UserInformation::where(['user_id' => $user_id])->first();
        if(empty($user_address_details)){
            request()->session()->flash('alert-danger', 'Please update your address');
            return redirect('edit-profile');
        }
        if (empty($user_payment_details)) {
            $user_payment_details = new UserPaymentDetails();
            $user_payment_details->card_no = "";
            $user_payment_details->expiry_date = "";
            $user_payment_details->cvv = "";
            $user_payment_details->name_on_card = "";
        }
        return view('payments.payment-page', compact('user_payment_details', 'user_address_details'));
    }

    /*
    * To save the payment details into database for further processing
    */
    public function savePaymentPage(StorePaymentDetails $request)
    {
        $request->validated();

        $user = Auth::user();
        $user_id = $user->id;
        $user_activity = UserActivityDetails::where(['user_id' => $user_id])->first();
        if ($user_activity) {
            $user_activity->step_to_complete = 5;
            $user_activity->save();
        }

        $user_payment_details = UserPaymentDetails::where(['user_id' => $user_id])->first();

        if ($user_payment_details) {
            $user_payment_details->card_no = $request->card_no;
            $user_payment_details->expiry_date = $request->expiry_date;
            $user_payment_details->cvv = $request->cvv;
            $user_payment_details->name_on_card = $request->name_on_card;
            $user_payment_details->save();
        } else {

            $user_payment_details = new UserPaymentDetails();
            $user_payment_details->user_id = $user_id;
            $user_payment_details->card_no = $request->card_no;
            $user_payment_details->expiry_date = $request->expiry_date;
            $user_payment_details->cvv = $request->cvv;
            $user_payment_details->name_on_card = $request->name_on_card;
            $user_payment_details->save();
        }
        
        /*
        * To send Otp on user's Email address
        */
        $otpVal = GeneralHelper::generateNumericOTP(6);
        $otp_expires_time = Carbon::now()->addSeconds(180);
        $otp = new Otp();
        $otp->mobile_code = $user->country_code;
        $otp->mobile_no = $user->mobile_number;
        $otp->otp = $otpVal;
        $otp->event_type = 'payment-transaction-otp';
        $otp->expiry_date = $otp_expires_time;
        $otp->save();

        $site_title = GlobalValues::get('site_title');
        $site_email = GlobalValues::get('site_email');
        $email_template_key = "payment-transaction-otp";
        $email_template_view = "emails.payment-transaction-otp";
        $email_template = EmailTemplateTrans::where("template_key", $email_template_key)->first();
        $arr_keyword_values = array();
        $arr_keyword_values['FIRST_NAME'] = $user->first_name;
        $arr_keyword_values['LAST_NAME'] = $user->last_name;
        $arr_keyword_values['OTP_CODE'] = $otpVal;
        $arr_keyword_values['TXN_AMOUNT'] = '$'.number_format($user_activity->send_amount,2);
        $arr_keyword_values['SITE_TITLE'] = $site_title;
        $arr_keyword_values['SITE_URL'] = url('/');
        if ($user->email != ""){
            $job = (new SendEmailQueue($email_template_view, $arr_keyword_values, $user->email, $email_template->subject));
            dispatch($job);
            request()->session()->flash('alert-success', 'OTP sent on your '.$user->email.' email address to complete the transaction.');
        }

        return redirect()->route('payment-confirmation');
    }


    /*
    * To display all steps information before sending the money to receipient
    */
    public function paymentConfirmation()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $user_activity = UserActivityDetails::where(['user_id' => $user_id])->first();
        if ($user_activity) {
            $user_activity->step_to_complete = 5;
            $user_activity->save();
        }

        $current_rate = session('current_rate');

        $user_sender_details = UserSenderDetails::where(['user_id' => $user_id])->first();
        $user_recipient_details = UserRecipientDetails::where(['user_id' => $user_id])->first();

        return view('payments.payment-confirmation', compact('user_activity', 'current_rate', 'user_sender_details', 'user_recipient_details'));
    }

    /*
    * To resend OTP
    */
    public function paymentResendOTP(){
        $user = Auth::user();
        $user_id = $user->id;
        $user_activity = UserActivityDetails::where(['user_id' => $user_id])->first();

        $otpVal = GeneralHelper::generateNumericOTP(6);
        $otp_expires_time = Carbon::now()->addSeconds(180);
        $otp = new Otp();
        $otp->mobile_code = $user->country_code;
        $otp->mobile_no = $user->mobile_number;
        $otp->otp = $otpVal;
        $otp->event_type = 'payment-transaction-otp';
        $otp->expiry_date = $otp_expires_time;
        $otp->save();

        $site_title = GlobalValues::get('site_title');
        $site_email = GlobalValues::get('site_email');
        $email_template_key = "payment-transaction-otp";
        $email_template_view = "emails.payment-transaction-otp";
        $email_template = EmailTemplateTrans::where("template_key", $email_template_key)->first();
        $arr_keyword_values = array();
        $arr_keyword_values['FIRST_NAME'] = $user->first_name;
        $arr_keyword_values['LAST_NAME'] = $user->last_name;
        $arr_keyword_values['OTP_CODE'] = $otpVal;
        $arr_keyword_values['TXN_AMOUNT'] = '$'.number_format($user_activity->send_amount,2);
        $arr_keyword_values['SITE_TITLE'] = $site_title;
        $arr_keyword_values['SITE_URL'] = url('/');
        if ($user->email != ""){
            $job = (new SendEmailQueue($email_template_view, $arr_keyword_values, $user->email, $email_template->subject));
            dispatch($job);
            request()->session()->flash('alert-success', 'OTP sent on your '.$user->email.' email address to complete the transaction.');
        }  

        return redirect()->route('payment-confirmation');
    }

    /*
    * Save the payment details into database for further processing
    */
    public function savePaymentConfirmation(Request $request)
    {
        $user_id = Auth::user()->id;

        $otp = Otp::where(['otp' => $request->otp,'event_type' => 'payment-transaction-otp'])->orderBy('id', 'desc')->first();
        if(isset($otp)){
            $otp_expires_time = Carbon::now();
            if($request->otp == $otp->otp){
                if(strtotime($otp_expires_time) > strtotime($otp->expiry_date)) {
                    return redirect()->route('save-payment-confirmation')->with('alert-danger', 'OTP expired');
                }else{
                    $obj_thunes = new ThunesController();
                    $obj_thunes->createQuotation();

                    

                    /*$errorMsg = $thunes_status['message'];
                    if($thunes_status['success']){
                        $alert_type = 'alert-success';
                        $request->session()->forget(['send_amount', 'receive_amount', 'bank_name', 'bank_id']);
                    }else{
                        $alert_type = 'alert-danger';
                    }*/
                    if (!empty(session('error_msg'))) {
                        $alert_type = 'alert-danger';
                        $errorMsg = session('error_msg');
                    } else {
                        $user_activity = UserActivityDetails::where(['user_id' => $user_id])->first();
                        if (isset($user_activity)) {
                            $user_activity->delete();
                        }

                        $user_sender_details = UserSenderDetails::where(['user_id' => $user_id])->first();
                        if (isset($user_sender_details)) {
                            //$user_sender_details->delete();
                        }

                        $user_recipient_details = UserRecipientDetails::where(['user_id' => $user_id])->first();
                        if (isset($user_recipient_details)) {
                            //$user_recipient_details->delete();
                        }

                        $user_payment_details = UserPaymentDetails::where(['user_id' => $user_id])->first();
                        if (isset($user_payment_details)) {
                            //$user_payment_details->delete();
                        }
                        $alert_type = 'alert-success';
                        $errorMsg = "Transaction created successfully";
                    }

                    $request->session()->forget(['send_amount', 'receive_amount', 'bank_name', 'bank_id']);
                    return redirect()->route('payment-success')->with($alert_type, $errorMsg);
                }
            }else{
                return redirect()->route('payment-confirmation')->with('alert-danger', 'Invalid OTP');
            }
        }else{
            return redirect()->route('payment-confirmation')->with('alert-danger', 'Invalid OTP');
        }

        
    }

    public function paymentSuccess(){
        return view('payments.payment-success');
    }

    public function startOver()
    {
        $user_id = Auth::user()->id;
        $user_activity = UserActivityDetails::where(['user_id' => $user_id])->first();

        if (isset($user_activity)) {
            $country_detail = ReceivingCountry::where(['country_iso_code' => $user_activity->receive_country])->first();
            $user_recipient_details = UserRecipientDetails::where(['user_id' => $user_id, 'country_code' => $country_detail->phone_code])->get();

            if ($user_recipient_details->count() > 1) {
                return view('payments.start-over', compact('user_recipient_details', 'user_activity'));
            } else {
                return redirect()->route('send-receive-details');
            }
        }
        return redirect()->route('send-receive-details');
    }

    public function saveStartOver(Request $request)
    {
        session(['start_over_selected_recipient' => $request->selecetd_recipient]);
        return redirect()->route('send-receive-details');
    }

    public function transferHistory()
    {
        $user_id = Auth::user()->id;
        $transfer_histories = UserPaymentTransaction::where(['user_id' => $user_id])->orderBy('id', 'desc')->get();

        return view('payments.transfer-history', compact('transfer_histories'));
    }

    public function receiptDetails($transaction_id)
    {
        $user_id = Auth::user()->id;
        $receipt_details = UserPaymentTransaction::where(['user_id' => $user_id, 'transaction_id' => $transaction_id])->first();
        $transaction_response = json_decode($receipt_details->transaction_response);

        //dd($transaction_response);
        /*if(isset($receipt_details)){
            $alert_type = 'alert-danger';
            $errorMsg = 'Invalid transaction';
            return redirect()->route('transfer-history')->with($alert_type, $errorMsg);
        }*/
        return view('payments.receipt-details', compact('receipt_details', 'transaction_response'));
    }

    public function sendingLimits()
    {
        $user_id = Auth::user()->id;
        $items = SendingLimit::where('status', 1)->get();
        //dd($items);
        $today = date('Y-m-d');

        $thirty_days = date('Y-m-d', strtotime($today . ' - 30 days'));
        $half_yearly = date('Y-m-d', strtotime($today . ' - 180 days'));

        $oneDayTotalAmountSent = UserPaymentTransaction::where('user_id', $user_id)->whereDate('created_at', '=', $today)->groupBy("user_id")->sum('sent_amount');

        $thirtyDaysTotalAmountSent = UserPaymentTransaction::where('user_id', $user_id)->whereDate('created_at', '>=', $thirty_days)->groupBy("user_id")->sum('sent_amount');

        $halfYearlyTotalAmountSent = UserPaymentTransaction::where('user_id', $user_id)->whereDate('created_at', '>=', $half_yearly)->groupBy("user_id")->sum('sent_amount');

        return view('payments.sending-limits', compact('items', 'oneDayTotalAmountSent', 'thirtyDaysTotalAmountSent', 'halfYearlyTotalAmountSent'));
    }

    public function generateReceiptPdf($transaction_id)
    {
        $user_id = auth()->user()->id;
        $receipt_details = UserPaymentTransaction::where(['user_id' => $user_id, 'transaction_id' => $transaction_id])->first();
        $transaction_response = json_decode($receipt_details->transaction_response);

        if (isset($receipt_details) && isset($transaction_response)) {
            $items = [];
            //            return view('Wallets::wallets.pdf-view', compact('items', 'start_date', 'end_date'));
            $items['receipt_details'] = $receipt_details;
            $items['transaction_response'] = $transaction_response;
            // dd($items);
            // share data to view
            view()->share('items', $items);
            $pdf = PDF::loadView('payments.receipt-pdf-details', $items);
            // return view('payments.receipt-pdf-details', compact('items'));

            // download PDF file with download method
            return $pdf->download('payzz-receipt-details-' . time() . '.pdf');
        } else {
            return redirect()->route('send-receive-details')
                ->with("alert-danger", "Something went wrong!!!");
        }
    }
}
