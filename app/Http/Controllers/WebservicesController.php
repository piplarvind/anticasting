<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Piplmodules\Users\Models\User;
use App\Models\UserInformation;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use GlobalValues;
use App\Helpers\GeneralHelper;
use App\Jobs\SendEmailQueue;
use Piplmodules\Emailtemplates\Models\EmailTemplateTrans;
use Piplmodules\ReceivingCountry\Models\ReceivingCountry;
use App\Models\UserActivityDetails;
use App\Models\UserRecipientDetails;
use App\Http\Requests\StoreRecipientDetails;
use App\Http\Controllers\PlaidController;
use App\Models\Payer;
use App\Models\UserSenderDetails;
use App\Models\UserPaymentDetails;
use App\Models\UserSubscriptionAttr;
use App\Models\UserPaymentTransaction;
use App\Http\Controllers\ThunesController;
use Carbon\Carbon;
use App\Models\Otp;


class WebservicesController extends Controller
{
  
    /*
    * To view user's profile information
    */
    public function viewProfile(Request $request){
        
        try{
            $responseData = new Collection();
            $user = User::where(['id'=>$request->user_id])->first();
            
            $responseData->add([
                'user_id'=>$user->id,
                'first_name'=>$user->first_name,
                'last_name'=>$user->last_name,
				'email'=>$user->email,
                'country_code'=>$user->country_code,
                'mobile_number'=>$user->mobile_number,
                'gender'=>$user->gender,
                'profile_photo_path'=>$user->profile_photo_path,
                'address_line_1'=> $user->userInformation->address_line_1,
                'city'=> $user->userInformation->city,
                'state'=> $user->userInformation->state,
                'country'=> $user->userInformation->country,
                'zip_code'=> $user->userInformation->zip_code,
                'send_money_from'=> $user->userInformation->send_money_from,
                'send_money_to'=> $user->userInformation->send_money_to,
                'referral_code'=> $user->userInformation->referral_code,
                'friend_referral_code'=> $user->userInformation->friend_referral_code

            ]);
            return response()->json([
                'success' => true,
                'responseData' => $responseData,
            ]);
        } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Could not find user profile',
                ], 500);
        }
    }

    /*
    * To edit user's profile information
    */
    public function editProfile(Request $request){
        $credentials = $request->only('first_name', 'last_name','address_line_1','city','address','state','zip_code');
        //valid credential
        $validator = Validator::make($credentials, [
            'first_name' => ['required','string'],
            'last_name' => ['required','string'],
            'address_line_1' => ['required'],
            'city' => ['required','string'],
            'state' => ['required','string'],
            'zip_code' => ['required','postal_code:MX,GU,HI,CR,SV'],
        ],[
            [
                'zip_code.postal_code' =>'Invalid zip code',
            ]
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['success' => false,'validationMessage' => $validator->messages()], 200);
        }

        $user = User::where(['id'=>$request->user_id])->first();
        if(isset($user)){
            $user->name = $request->first_name . " " . $request->last_name;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->save();

            $user = UserInformation::where(['id' => $user->id])->first();
            $user->address_line_1 = $request->address_line_1;
            $user->city = $request->city;
            $user->state = $request->state;
            $user->zip_code = $request->zip_code;
            $user->save();
            return response()->json([
                'success' => true,
                'message' => "Profile updated successfully",
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'User could not found',
            ], 500);
        }
    }

    /*
    * To list user's recipient information
    */
    public function recipientList(Request $request){
        $user_id = $request->user_id;
        try {
            $user_info = UserInformation::where(['user_id' => $user_id])->first();
            if(isset($user_info)){
                $country_detail = ReceivingCountry::where(['country_iso_code' => ($user_info->send_money_to) ? $user_info->send_money_to : 'MEX'])->first();
                if(isset($country_detail)){
                    $recipients = UserRecipientDetails::where(['user_id' => $user_id, 'country_code' => $country_detail->phone_code])->get();
                    //$recipients = UserRecipientDetails::where(['user_id' => $user_id])->get();
                    return response()->json([
                        'success' => true,
                        'responseData' => $recipients,
                    ]);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Youn have not set sending country',
                    ], 500);    
                }
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'User could not found',
                ], 500);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not find recipient list',
            ], 500);
        }
    }

    /*
    * To add & edit user's recipient information
    */
    public function  addEditRecipient(Request $request){
        $credentials = $request->only('first_name', 'last_name','bank_account_no','country_code','phone_no','email','city','address','state','reason_for_sending');
        //valid credential
        $validator = Validator::make($credentials, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'bank_account_no' => 'required',
            'country_code' => 'required',
            'phone_no' => 'required|numeric',
            'email' => 'nullable|email',
            'city' => 'required|string',
            'address' => 'required',
            'state' => 'required|string',
            'reason_for_sending' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['success' => false,'validationMessage' => $validator->messages()], 200);
        }

        $user = User::where(['id'=>$request->user_id])->first();
        if(isset($user)){
            if ($request->recipient_id !="") {
                $errorMsg = "Recipient edited successfully";
                $user_recipient_details = UserRecipientDetails::where(['id' => $request->recipient_id, 'user_id' => $user->id])->first();
            } else {
                $errorMsg = "Recipient added successfully";
                $user_recipient_details = new UserRecipientDetails();
            }
            try{
                $user_recipient_details->user_id = $user->id;
                $user_recipient_details->bank_account_no = $request->bank_account_no;
                $user_recipient_details->first_name = $request->first_name;
                $user_recipient_details->last_name = $request->last_name;
                $user_recipient_details->bank_account_no = $request->bank_account_number;
                $user_recipient_details->phone_no = $request->phone_no;
                $user_recipient_details->country_code = $request->country_code;
                $user_recipient_details->email = $request->email;
                $user_recipient_details->address = $request->address;
                $user_recipient_details->city = $request->city;
                $user_recipient_details->state = $request->state;
                $user_recipient_details->reason_for_sending = $request->reason_for_sending;
                $user_recipient_details->save();
                return response()->json([
                    'success' => true,
                    'message' => $errorMsg
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Could not find recipient list',
                ], 500);
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'User could not found',
            ], 500);
        }
    }

    

    public function userList(Request $request) {
        try {
            $users = User::where('user_type', '2')
                ->FilterName()
                ->FilterStatus()
                ->orderBy('id', 'DESC')
                ->paginate($request->get('paginate'));
            $users->appends($request->except('page'));
            return response()->json([
                'success' => true,
                'responseData' => $users,
            ]);
        } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Could not find user list',
                ], 500);
        }
        
    }

    public function changeSendToCountry(Request $request)
    {
        $credentials = $request->only('user_id', 'country_iso_code');
        //valid credential
        $validator = Validator::make($credentials, [
            'user_id' => 'required',
            'country_iso_code' => 'required|string'
        ],[
            'country_iso_code.required' => "Please select country"
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['success' => false,'validationMessage' => $validator->messages()], 200);
        }

        $user = UserInformation::where(['user_id'=>$request->user_id])->first();
        if(isset($user)){
            $user->send_money_to = $request->country_iso_code;
            $user->save();
            $site_title = GlobalValues::get('site_title');
            $site_email = GlobalValues::get('site_email');
            $email_template_key = "changed-country";
            $email_template_view = "emails.changed-country";
            $email_template = EmailTemplateTrans::where("template_key", $email_template_key)->first();
            $arr_keyword_values = array();
            $arr_keyword_values['FIRST_NAME'] = $user->first_name;
            $arr_keyword_values['LAST_NAME'] = $user->last_name;
            $arr_keyword_values['SITE_TITLE'] = $site_title;
            $arr_keyword_values['SITE_URL'] = url('/');
            if ($user->user->email != ""){
                $job = (new SendEmailQueue($email_template_view, $arr_keyword_values, $user->user->email, $email_template->subject));
                dispatch($job);
            }
            return response()->json(['success' => true,'message' => 'Country updated successfully'], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'User could not found',
            ], 500);
        }
    }

    public function receivingCountries(){
        
        $data = ReceivingCountry::where('status',1)->orderBy('country_name')->get();
        if($data->count() > 0){
            $image_path = url('/public/country');
            return response()->json(['success' => true, 'responseData' => $data,'image_path' =>$image_path, 'message' => ''], 200);
        }else{
            return response()->json(['success' => false,'message' => 'Country not available'], 200);
        }
        
    }
    
    public function globalFee(){
        
        $data = GlobalValues::get('fees');
        
        if($data){
            $data = new collection([
                'fees' => $data
            ]);
            return response()->json(['success' => true, 'responseData' => $data, 'message' => ''], 200);
        }else{
            return response()->json(['success' => false,'message' => 'Country not available'], 200);
        }
        
    }

    public function currentRate(Request $request){
        
        $user_id = $request->user_id;
        $selected_send_country = UserInformation::where(['user_informations.id' => $user_id])->leftJoin('payers', function ($join) {
            $join->on('payers.payer_country', '=', 'user_informations.send_money_to');
        })->first();

        if (empty($selected_send_country->payer_id)) {
            return response()->json(['success' => false,'message' => 'Please set send country first'], 200);
        }

        $url = 'payers/' . $selected_send_country->payer_id . '/rates';
        $request_type = 'GET';
        $post_data = [];
        $res = GeneralHelper::thunesAPI($url, $request_type, $post_data);

        if(isset($res->errors)){
           return response()->json(['success' => false,'message' => $res->errors[0]->message.', please contact administrator'], 200);
        }
    
        $current_rate = ($res) ? number_format($res->rates->C2C->USD[0]->wholesale_fx_rate, 2) : 0;

        $data = new collection([
            'current_rate' => $current_rate
        ]);
        return response()->json(['success' => true, 'responseData' => $data, 'message' => ''], 200);
        
    }

    public function getPayers(Request $request){
        $user_id = $request->user_id;
        $selected_send_country = UserInformation::where(['user_informations.id' => $user_id])->leftJoin('payers', function ($join) {
            $join->on('payers.payer_country', '=', 'user_informations.send_money_to');
        })->first();

        if (empty($selected_send_country->payer_id)) {
            return response()->json(['success' => false,'message' => 'Please set send country first'], 200);
        }

        $payers = Payer::where(['payer_country' => $selected_send_country->payer_country])->groupBy('payer_service')->get();
        
        if($payers->count()){
            return response()->json(['success' => true, 'responseData' => $payers, 'message' => ''], 200);
        }else{
            return response()->json(['success' => false,'message' => 'Delivery method not found, please contact administrator'], 200);
        }
    }

    public function getDeliveryLocation(Request $request){
        $payers = Payer::where(['payer_service' => $request->payer_service, 'payer_country' => $request->payer_country])->get();
        if($payers->count()){
            return response()->json(['success' => true, 'responseData' => $payers, 'message' => ''], 200);
        }else{
            return response()->json(['success' => false,'message' => 'Delivery location not found, please contact administrator'], 200);
        }
    }

    public function getSendMoneyDetail(Request $request){
        try{
            $user_id = $request->user_id;

            $user_activity = UserActivityDetails::where(['user_id' => $user_id])->first();
            return response()->json(['success' => true, 'responseData' => $user_activity, 'message' => ''], 200);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again',
            ], 500);
        }
    }

    public function saveSendMoneyStepOne(Request $request){
        try{
            $credentials = $request->only('user_id', 'send_amount','receive_amount','receive_currency','receive_country');
            //valid credential
            $validator = Validator::make($credentials, [
                'user_id' => 'required',
                'send_amount' =>'required|numeric',
                'receive_amount' =>'required|numeric',
                'receive_currency' =>'required',
                'receive_country' => 'required'
            ]);

            //Send failed response if request is not valid
            if ($validator->fails()) {
                return response()->json(['success' => false,'validationMessage' => $validator->messages()], 200);
            }
            $user_id = $request->user_id;

            $user_activity = UserActivityDetails::where(['user_id' => $user_id])->first();
            
            $send_amount = $request->send_amount;
            $receive_amount = $request->receive_amount;
            $receive_currency = $request->receive_currency;
            $receive_country = $request->receive_country;

            $sharedSendingLimit = UserSubscriptionAttr::where(['user_id' => $user_id])->orderBy('id', 'DESC')->first();

            $today = date('Y-m-d');

            $thirty_days = date('Y-m-d', strtotime($today . ' - 30 days'));
            $half_yearly = date('Y-m-d', strtotime($today . ' - 180 days'));

            $oneDayTotalAmountSent = UserPaymentTransaction::where('user_id', $user_id)->whereDate('created_at', '=', $today)->groupBy("user_id")->sum('sent_amount');

            $thirtyDaysTotalAmountSent = UserPaymentTransaction::where('user_id', $user_id)->whereDate('created_at', '>=', $thirty_days)->groupBy("user_id")->sum('sent_amount');

            $halfYearlyTotalAmountSent = UserPaymentTransaction::where('user_id', $user_id)->whereDate('created_at', '>=', $half_yearly)->groupBy("user_id")->sum('sent_amount');

            if(($sharedSendingLimit->one_day_price - $oneDayTotalAmountSent) < $send_amount ){
                return response()->json(['success' => false,'message' => "Receive amount should not be greater than " . ($sharedSendingLimit->one_day_price - $oneDayTotalAmountSent). " for 24 hours limit"], 200);
            }

            if(($sharedSendingLimit->thirty_day_price - $thirtyDaysTotalAmountSent) < $send_amount ){
                return response()->json(['success' => false,'message' => "Receive amount should not be greater than " .($sharedSendingLimit->thirty_day_price - $thirtyDaysTotalAmountSent). " for 30 days limit"], 200);
            }

            if(($sharedSendingLimit->half_yearly_price - $halfYearlyTotalAmountSent) < $send_amount ){
                return response()->json(['success' => false,'message' => "Receive amount should not be greater than " .($sharedSendingLimit->half_yearly_price - $halfYearlyTotalAmountSent). " for 180 days limit"], 200);
            }

            if ($user_activity) {
                $user_activity->send_amount = $send_amount;
                $user_activity->receive_amount = $receive_amount;
                $user_activity->receive_currency = $receive_currency;
                $user_activity->receive_country = $receive_country;            
                $user_activity->save();
            } else {
                $user_activity = new UserActivityDetails();
                $user_activity->user_id = $user_id;
                $user_activity->send_amount = $send_amount;
                $user_activity->receive_amount = $receive_amount;
                $user_activity->receive_currency = $receive_currency;
                $user_activity->receive_country = $receive_country;
                $user_activity->save();
            }
            return response()->json(['success' => true, 'responseData' => $user_activity, 'message' => 'Record save successfully'], 200);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again',
            ], 500);
        }
    }

    public function saveSendMoneyStepTwo(Request $request){
        try{
            $credentials = $request->only('user_id', 'bank_name','payment_method');
            //valid credential
            $validator = Validator::make($credentials, [
                'user_id' => 'required',
                'bank_name' =>'required',
                'payment_method' =>'required'
            ]);

            //Send failed response if request is not valid
            if ($validator->fails()) {
                return response()->json(['success' => false,'validationMessage' => $validator->messages()], 200);
            }
            $user_id = $request->user_id;

            $user_activity = UserActivityDetails::where(['user_id' => $user_id])->first();
            
            $bank_name = $request->bank_name;
            $payment_method = $request->payment_method;

            $payer_id = explode("###", $payment_method)[1];
            $payer_details = Payer::where(['payer_id' => $payer_id])->first();

            if (empty($payer_details)) {
                return response()->json(['success' => false,'message' => 'Invalid payer details'], 200);
            } else {
                $receive_amount = $user_activity->receive_amount;
                if ($payer_details->min_amount > 0.0 && $receive_amount < $payer_details->min_amount) {
                    return response()->json(['success' => false,'message' => "Receive amount should not be less than " . $payer_details->min_amount], 200);
                } else if ($payer_details->max_amount && $receive_amount > $payer_details->max_amount) {
                    return response()->json(['success' => false,'message' => "Receive amount should not be greated than " . $payer_details->max_amount], 200);
                }
            }
            
            if ($user_activity) {
                $user_activity->bank_name = $bank_name;
                $user_activity->payment_method = $payment_method;  
                $user_activity->step_to_complete = 2;        
                $user_activity->save();
            } else {
                $user_activity = new UserActivityDetails();
                $user_activity->user_id = $user_id;
                $user_activity->bank_name = $bank_name;
                $user_activity->payment_method = $payment_method;
                $user_activity->step_to_complete = 2;
                $user_activity->save();
            }
            return response()->json(['success' => true, 'responseData' => $user_activity, 'message' => 'Record save successfully'], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again',
            ], 500);
        }
    }

    public function getRecipientDetail(Request $request){
        try{
            $user_id = $request->user_id;
            $selected_recipient_id = ($request->selected_recipient_id)?$request->selected_recipient_id:null;
            $user_info = UserInformation::where(['user_id' => $user_id])->first();
            $country_detail = ReceivingCountry::where(['country_iso_code' => ($user_info->send_money_to) ? $user_info->send_money_to : 'MEX'])->first();
            
            $user_recipient_list = UserRecipientDetails::where(['user_id' => $user_id, 'country_code' => $country_detail->phone_code])->orderBy('id','desc')->get();
            $user_recipient_details = collect();
            $user_recipient_details->bank_account_no = "";
            if ($selected_recipient_id != null) {
                $user_recipient_details = UserRecipientDetails::where(['id' => $selected_recipient_id])->first();
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
            return response()->json(['success' => true, 'responseData' => ['user_recipient_list' => $user_recipient_list ,'user_recipient_details' => $user_recipient_details], 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again',
            ], 500);
        }
    }
    
    public function saveRecipientStepOne(Request $request){

        try {
            
            $credentials = $request->only('user_id', 'bank_account_no','first_name','last_name','phone_no','country_code');
            //valid credential

            $min = 14;
            $user_id = $request->user_id;
            $user_activity_details = UserActivityDetails::where(['user_id' => $user_id])->first();
            
            if (isset($user_activity_details) && $user_activity_details->receive_country == 'MEX' && explode("###", $user_activity_details->payment_method)[0] == 'BankAccount') {
                $min = 18;
            }
            if(explode("###", $user_activity_details->payment_method)[0] == 'BankAccount'){
                $validator = Validator::make($credentials, [
                    'user_id' => 'required',
                    'bank_account_no' =>'required',
                    'first_name' =>'required',
                    'last_name' =>'required',
                    'phone_no' =>'required',
                    'country_code' =>'required'
                ],[
                    'bank_account_no' => 'required|min:'.$min,
                ]);
            }else{
                $validator = Validator::make($credentials, [
                    'user_id' => 'required',
                    'first_name' =>'required',
                    'last_name' =>'required',
                    'phone_no' =>'required',
                    'country_code' =>'required'
                ]);
            }

            //Send failed response if request is not valid
            if ($validator->fails()) {
                return response()->json(['success' => false,'validationMessage' => $validator->messages()], 200);
            }
            

            $selected_send_country = UserInformation::where(['user_informations.id' => $user_id])->leftJoin('payers', function ($join) {
                $join->on('payers.payer_country', '=', 'user_informations.send_money_to');
            })->first();

            if (empty($selected_send_country->payer_id)) {
                return response()->json(['success' => false,'message' => 'Please set send country first'], 200);
            }

            $user_recipient_details = UserRecipientDetails::where(['user_id' => $user_id])->first();

            if ($user_recipient_details) {
                $user_recipient_details->bank_account_no = ($request->bank_account_no)?$request->bank_account_no:null;
                $user_recipient_details->first_name = $request->first_name;
                $user_recipient_details->last_name = $request->last_name;
                $user_recipient_details->phone_no = $request->phone_no;
                $user_recipient_details->country_code = $request->country_code;
                $user_recipient_details->save();
            } else {
                $user_recipient_details = new UserRecipientDetails();
                $user_recipient_details->user_id = $user_id;
                $user_recipient_details->bank_account_no = ($request->bank_account_no)?$request->bank_account_no:null;
                $user_recipient_details->first_name = $request->first_name;
                $user_recipient_details->last_name = $request->last_name;
                $user_recipient_details->phone_no = $request->phone_no;
                $user_recipient_details->country_code = $request->country_code;
                $user_recipient_details->save();
            }
            return response()->json(['success' => true, 'responseData' => $user_recipient_details, 'message' => 'Record save successfully'], 200);
        }catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again',
            ], 500);
        }
    }

    public function saveRecipientStepTwo(Request $request){

        try {
            
            $credentials = $request->only('user_id', 'address','city','state','reason_for_sending');
            //valid credential
            $validator = Validator::make($credentials, [
                'user_id' => 'required',
                'address' =>'required',
                'city' =>'required',
                'state' =>'required',
                'reason_for_sending' =>'required'
            ]);

            //Send failed response if request is not valid
            if ($validator->fails()) {
                return response()->json(['success' => false,'validationMessage' => $validator->messages()], 200);
            }
            $user_id = $request->user_id;

            $selected_send_country = UserInformation::where(['user_informations.id' => $user_id])->leftJoin('payers', function ($join) {
                $join->on('payers.payer_country', '=', 'user_informations.send_money_to');
            })->first();

            if (empty($selected_send_country->payer_id)) {
                return response()->json(['success' => false,'message' => 'Please set send country first'], 200);
            }

            $user_activity = UserActivityDetails::where(['user_id' => $user_id])->first();
            if ($user_activity) {
                $user_activity->step_to_complete = 3;
                $user_activity->save();
            }

            $user_recipient_details = UserRecipientDetails::where(['user_id' => $user_id])->first();

            if ($user_recipient_details) {
              
                $user_recipient_details->address = $request->address;
                $user_recipient_details->city = $request->city;
                $user_recipient_details->state = $request->state;
                $user_recipient_details->reason_for_sending = $request->reason_for_sending;
                $user_recipient_details->save();
            } else {
                $user_recipient_details = new UserRecipientDetails();
                $user_recipient_details->user_id = $user_id;                
                $user_recipient_details->address = $request->address;
                $user_recipient_details->city = $request->city;
                $user_recipient_details->state = $request->state;
                $user_recipient_details->reason_for_sending = $request->reason_for_sending;
                
                $user_recipient_details->save();
            }
            return response()->json(['success' => true, 'responseData' => $user_recipient_details, 'message' => 'Record save successfully'], 200);
        }catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again',
            ], 500);
        }
    }

    public function getSenderDetail(Request $request){
        try{
            $user_id = $request->user_id;
            //$user_sender_details = UserSenderDetails::where(['user_id' => $user_id])->orderBy('id', 'DESC')->first();
            $user_sender_details = UserInformation::where(['user_id' => $user_id])->first();
            
            $user_sender_details->first_name = $user_sender_details->user->first_name;
            $user_sender_details->last_name = $user_sender_details->user->last_name;
   
            return response()->json(['success' => true, 'responseData' => $user_sender_details, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again',
            ], 500);
        }
    }

    public function saveSenderStepOne(Request $request){
        try {
            $credentials = $request->only('user_id', 'first_name','last_name', 'phone_no','country_code');
            //valid credential
            $validator = Validator::make($credentials, [
                'user_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'phone_no' =>'required',
                'country_code' => 'required'
            ]);

            //Send failed response if request is not valid
            if ($validator->fails()) {
                return response()->json(['success' => false,'validationMessage' => $validator->messages()], 200);
            }
            $user_id = $request->user_id;

            $user_sender_details = UserSenderDetails::where(['user_id' => $user_id])->first();

            if ($user_sender_details) {
                $user_sender_details->first_name = $request->first_name;
                $user_sender_details->last_name = $request->last_name;
                $user_sender_details->phone_no = $request->phone_no;
                $user_sender_details->country_code = $request->country_code;
                $user_sender_details->save();
            } else {
                $user_sender_details = new UserSenderDetails();
                $user_sender_details->user_id = $user_id;
                $user_sender_details->first_name = $request->first_name;
                $user_sender_details->last_name = $request->last_name;
                $user_sender_details->phone_no = $request->phone_no;
                $user_sender_details->save();
            }
            return response()->json(['success' => true, 'responseData' => $user_sender_details, 'message' => 'Record save successfully'], 200);
        }catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again',
            ], 500);
        }
    }

    public function saveSenderStepTwo(Request $request){
        try {
            $credentials = $request->only('user_id', 'address_line_1','address_line_2','city','state','zip_code');
            //valid credential
            $validator = Validator::make($credentials, [
                'user_id' => 'required',
                'address_line_1' =>'required',
                'city' =>'required',
                'state' =>'required',
                'zip_code' =>'required'
            ]);

            //Send failed response if request is not valid
            if ($validator->fails()) {
                return response()->json(['success' => false,'validationMessage' => $validator->messages()], 200);
            }
            $user_id = $request->user_id;

            $user_sender_details = UserSenderDetails::where(['user_id' => $user_id])->first();

            if ($user_sender_details) {
                $user_sender_details->address_line_1 = $request->address_line_1;
                $user_sender_details->address_line_2 = ($request->address_line_2)?$request->address_line_2:null;
                $user_sender_details->state = $request->state;
                $user_sender_details->city = $request->city;
                $user_sender_details->zip_code = $request->zip_code;
                $user_sender_details->save();
            } else {
                $user_sender_details = new UserSenderDetails();
                $user_sender_details->user_id = $user_id;
                $user_sender_details->address_line_1 = $request->address_line_1;
                $user_sender_details->address_line_2 = ($request->address_line_2)?$request->address_line_2:null;
                $user_sender_details->state = $request->state;
                $user_sender_details->city = $request->city;
                $user_sender_details->zip_code = $request->zip_code;
                $user_sender_details->save();
            }
            return response()->json(['success' => true, 'responseData' => $user_sender_details, 'message' => 'Record save successfully'], 200);
        }catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again',
            ], 500);
        }
    }

    public function saveSenderStepThree(Request $request){
        try {
            $credentials = $request->only('user_id', 'dob');
            //valid credential
            $validator = Validator::make($credentials, [
                'user_id' => 'required',
                'dob' => 'required'
            ]);

            //Send failed response if request is not valid
            if ($validator->fails()) {
                return response()->json(['success' => false,'validationMessage' => $validator->messages()], 200);
            }
            $user_id = $request->user_id;

            $user_activity = UserActivityDetails::where(['user_id' => $user_id])->first();
            if ($user_activity) {
                $user_activity->step_to_complete = 4;
                $user_activity->save();
            }

            $user_sender_details = UserSenderDetails::where(['user_id' => $user_id])->first();

            if ($user_sender_details) {
                $user_sender_details->dob = date('Y-m-d', strtotime($request->dob));
                $user_sender_details->save();
            } else {
                $user_sender_details = new UserSenderDetails();
                $user_sender_details->user_id = $user_id;
                $user_sender_details->dob = date('Y-m-d', strtotime($request->dob));
                $user_sender_details->save();
            }
            return response()->json(['success' => true, 'responseData' => $user_sender_details, 'message' => 'Record save successfully'], 200);
        }catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again',
            ], 500);
        }
    }

    public function getPaymentPageDetail(Request $request){
        try{
            $user_id = $request->user_id;

            $user_address_details = UserInformation::where(['user_id' => $user_id])->first();
            return response()->json(['success' => true, 'responseData' => $user_address_details, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again',
            ], 500);
        }        
    }

    /*
    * To save the payment details into database for further processing
    */
    public function savePaymentPageDetail(Request $request)
    {
        try{
            $credentials = $request->only('user_id');
            //valid credential
            $validator = Validator::make($credentials, [
                'user_id' => 'required'
            ]);

            //Send failed response if request is not valid
            if ($validator->fails()) {
                return response()->json(['success' => false,'validationMessage' => $validator->messages()], 200);
            }
            $user_id = $request->user_id;
            $user = $user = User::where(['id'=>$user_id])->first();
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
                return response()->json(['success' => true, 'responseData' => [], 'message' => 'OTP sent on your '.$user->email.' email address to complete the transaction'], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again',
            ], 500);
        } 
    }

    public function getPaymentConfirmationStepOne(Request $request){
        try{
            $user_id = $request->user_id;
            $user_activity = UserActivityDetails::where(['user_id' => $user_id])->first();
            

            $fee = GlobalValues::get('fees').' USD';
            
            $selected_send_country = UserInformation::where(['user_informations.id' => $user_id])->leftJoin('payers', function ($join) {
                $join->on('payers.payer_country', '=', 'user_informations.send_money_to');
            })->first();
    
            if (empty($selected_send_country->payer_id)) {
                return response()->json(['success' => false,'message' => 'Please set send country first'], 200);
            }
    
            $url = 'payers/' . $selected_send_country->payer_id . '/rates';
            $request_type = 'GET';
            $post_data = [];
            $res = GeneralHelper::thunesAPI($url, $request_type, $post_data);
    
            if(isset($res->errors)){
               return response()->json(['success' => false,'message' => $res->errors[0]->message.', please contact administrator'], 200);
            }
        
            $current_rate = ($res) ? number_format($res->rates->C2C->USD[0]->wholesale_fx_rate, 2) : 0;

            $user_sender_details = UserSenderDetails::where(['user_id' => $user_id])->first();
            $user_recipient_details = UserRecipientDetails::where(['user_id' => $user_id])->first();
            return response()->json(['success' => true, 'responseData' => ['fee'=>$fee,'current_rate'=>$current_rate, 'user_activity'=>$user_activity], 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again',
            ], 500);
        } 
    }

    public function getPaymentConfirmationStepTwo(Request $request){
        try{
            $user_id = $request->user_id;
            $user_activity = UserActivityDetails::where(['user_id' => $user_id])->first();
            if ($user_activity) {
                $user_activity->step_to_complete = 5;
                $user_activity->save();
            }

            $user_sender_details = UserSenderDetails::where(['user_id' => $user_id])->first();
            $user_recipient_details = UserRecipientDetails::where(['user_id' => $user_id])->first();
            return response()->json(['success' => true, 'responseData' => ['user_sender_details' =>$user_sender_details, 'user_recipient_details'=>$user_recipient_details], 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again',
            ], 500);
        } 
    }

    public function paymentResendOTP(Request $request){
        try {
            $user_id = $request->user_id;
            $user = $user = User::where(['id'=>$user_id])->first();
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
                return response()->json(['success' => true, 'responseData' => [], 'message' => 'OTP sent on your '.$user->email.' email address to complete the transaction'], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again',
            ], 500);
        }
    }

    public function savePaymentConfirmation(Request $request){
        try {
            $credentials = $request->only('user_id','otp');
            //valid credential
            $validator = Validator::make($credentials, [
                'user_id' => 'required',
                'otp' => 'required'
            ]);

            //Send failed response if request is not valid
            if ($validator->fails()) {
                return response()->json(['success' => false,'validationMessage' => $validator->messages()], 200);
            }
            $user_id = $request->user_id;

            $otp = Otp::where(['otp' => $request->otp,'event_type' => 'payment-transaction-otp'])->orderBy('id', 'desc')->first();
            if(isset($otp)){
                $otp_expires_time = Carbon::now();
                if($request->otp == $otp->otp){
                    if(strtotime($otp_expires_time) > strtotime($otp->expiry_date)) {
                        return response()->json(['success' => false,'message' => 'OTP expired'], 200);
                    }else{
                        $obj_thunes = new ThunesController();
                        $responseData = $obj_thunes->createQuotation();

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
                            return response()->json(['success' => false,'message' => $errorMsg], 200);
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
                            //$alert_type = 'alert-success';
                            //$errorMsg = "Transaction created successfully";
                            return response()->json($responseData, 200);
                        }                        
                    }
                }else{
                    return response()->json(['success' => false,'message' => 'Invalid OTP'], 200);
                }
            }else{
                return response()->json(['success' => false,'message' => 'Invalid OTP'], 200);
            }
        }catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again',
            ], 500);
        }
    }
}
