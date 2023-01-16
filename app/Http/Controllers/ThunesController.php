<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GeneralHelper;
use App\Helpers\GlobalValues;
use App\Models\UserPaymentTransaction;
use App\Models\UserActivityDetails;
use App\Models\UserRecipientDetails;
use App\Models\UserSenderDetails;
use Illuminate\Support\Str;
use App\Models\Payer;
use Piplmodules\Notifications\Models\Notification;
use Piplmodules\Users\Models\UserPreference;
use Piplmodules\Emailtemplates\Models\EmailTemplateTrans;
use App\Jobs\SendEmailQueue;
use Illuminate\Support\Collection;

class ThunesController extends Controller
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

    /*
    * get payer
    */
    public function getPayers()
    {
        $url = 'payers';
        $request_type = 'GET';
        $post_data = [];
        $res = GeneralHelper::thunesAPI($url, $request_type, $post_data);
        //dd($res);
        if (is_array($res)) {
            foreach ($res as $payer) {

                $obj_payer = Payer::where(['payer_id' => $payer->id])->first();
                if (isset($obj_payer)) {
                    $obj_payer->payer_name = $payer->name;
                    $obj_payer->payer_country = $payer->country_iso_code;
                    $obj_payer->payer_service = $payer->service->name;
                    $obj_payer->payer_currency = $payer->currency;
                    $obj_payer->transaction_type = "C2C";
                    $obj_payer->min_amount = $payer->transaction_types->C2C->minimum_transaction_amount;
                    $obj_payer->max_amount = $payer->transaction_types->C2C->maximum_transaction_amount;
                    $obj_payer->precision = $payer->precision;
                    $obj_payer->increment = $payer->increment;
                    $obj_payer->required_sender = implode(",", $payer->transaction_types->C2C->required_sending_entity_fields[0]);
                    $obj_payer->required_beneficiary = implode(",", $payer->transaction_types->C2C->required_receiving_entity_fields[0]);
                    $obj_payer->credit_party_identifiers_accepted = implode(",", $payer->transaction_types->C2C->credit_party_identifiers_accepted[0]);
                    $obj_payer->credit_party_information_credit_party_identifiers_accepted = implode(",", $payer->transaction_types->C2C->credit_party_information->credit_party_identifiers_accepted[0]);
                    $obj_payer->credit_party_verification_credit_party_identifiers_accepted = implode(",", $payer->transaction_types->C2C->credit_party_verification->credit_party_identifiers_accepted[0]);
                    $obj_payer->credit_party_verification_required_receiving_entity_fields = implode(",", $payer->transaction_types->C2C->credit_party_verification->required_receiving_entity_fields[0]);
                    $obj_payer->required_documents = implode(",", $payer->transaction_types->C2C->required_documents[0]);

                    $obj_payer->save();
                    $msg = "Payer updated successfully";
                } else {
                    $obj_payer = new Payer();
                    $obj_payer->payer_id = $payer->id;
                    $obj_payer->payer_name = $payer->name;
                    $obj_payer->payer_country = $payer->country_iso_code;
                    $obj_payer->payer_service = $payer->service->name;
                    $obj_payer->payer_currency = $payer->currency;
                    $obj_payer->transaction_type = "C2C";
                    $obj_payer->min_amount = $payer->transaction_types->C2C->minimum_transaction_amount;
                    $obj_payer->max_amount = $payer->transaction_types->C2C->maximum_transaction_amount;
                    $obj_payer->precision = $payer->precision;
                    $obj_payer->increment = $payer->increment;
                    $obj_payer->required_sender = implode(",", $payer->transaction_types->C2C->required_sending_entity_fields[0]);
                    $obj_payer->required_beneficiary = implode(",", $payer->transaction_types->C2C->required_receiving_entity_fields[0]);
                    $obj_payer->credit_party_identifiers_accepted = implode(",", $payer->transaction_types->C2C->credit_party_identifiers_accepted[0]);
                    $obj_payer->credit_party_information_credit_party_identifiers_accepted = implode(",", $payer->transaction_types->C2C->credit_party_information->credit_party_identifiers_accepted[0]);
                    $obj_payer->credit_party_verification_credit_party_identifiers_accepted = implode(",", $payer->transaction_types->C2C->credit_party_verification->credit_party_identifiers_accepted[0]);
                    $obj_payer->credit_party_verification_required_receiving_entity_fields = implode(",", $payer->transaction_types->C2C->credit_party_verification->required_receiving_entity_fields[0]);
                    $obj_payer->required_documents = implode(",", $payer->transaction_types->C2C->required_documents[0]);

                    $obj_payer->save();
                    $msg = "Payer added scusseddfully";
                }
            }
            echo $msg;
        } else {
            echo $res->errors[0]->message;
        }
    }

    /**
     * Create payer
     */
    public function createPayer()
    {
        $url = 'balances';
        $request_type = 'POST';
        $post_data = [];
        $res = GeneralHelper::thunesAPI($url, $request_type, $post_data);
        dd($res);
    }

    public function getBalance()
    {
        $url = 'balances';
        $request_type = 'GET';
        $res = GeneralHelper::thunesAPI($url, $request_type);
        dd($res);
    }

    public function createQuotation()
    {
        $user_id = Auth::user()->id;
        $user_activity = UserActivityDetails::where(['user_id' => $user_id])->first();
        $url = 'quotations';
        $request_type = 'POST';
        $external_id = strtotime(date("Y-m-d H:i:s"));
        $post_data = [
            "external_id" => $external_id,
            "payer_id" => explode('###', $user_activity->payment_method)[1],
            "mode" => "SOURCE_AMOUNT",
            "transaction_type" => "C2C",
            "source" => [
                "amount" =>  $user_activity->send_amount,
                "currency" => "USD",
                "country_iso_code" => "USA"
            ],
            "destination" => [
                "amount" => $user_activity->receive_amount,
                "currency" => $user_activity->receive_currency
            ]
        ];
        $res = GeneralHelper::thunesAPI($url, $request_type, $post_data);
        //dd($res);
        if (isset($res->errors)) {
            $errorMsg = $res->errors[0]->message;
            //return redirect()->route('payment-confirmation')->with("alert-success", $errorMsg);
            session(['error_msg' => $errorMsg]);
        } else {
            return $this->createTransaction($external_id, $res->id);
        }
    }

    public function createTransaction($external_id, $quotation_id)
    {
        $user_id = Auth::user()->id;
        $user_recipient_details = UserRecipientDetails::where(['user_id' => $user_id])->first();
        $user_sender_details = UserSenderDetails::where(['user_id' => $user_id])->first();
        $user_activity_details = UserActivityDetails::where(['user_id' => $user_id])->first();
        $url = 'quotations/' . $quotation_id . '/transactions';
        $request_type = 'POST';

        if ($user_activity_details->receive_country == 'MEX' && explode("###", $user_activity_details->payment_method)[0] == 'BankAccount') {
            $credit_party_identifier =  [
                "clabe" => $user_recipient_details->bank_account_no
            ];
        }elseif ($user_activity_details->receive_country == 'CRI' && explode("###", $user_activity_details->payment_method)[0] == 'BankAccount') {
            $credit_party_identifier =  [
                "iban" => $user_recipient_details->bank_account_no
            ];
        } elseif (explode("###", $user_activity_details->payment_method)[0] == 'BankAccount') {
            $credit_party_identifier =  [
                "bank_account_number" => $user_recipient_details->bank_account_no
            ];
        } else {
            $credit_party_identifier =  [
                "msisdn" => $user_recipient_details->phone_no
            ];
        }
        $post_data = [
            "retail_rate" => "",
            "additional_information_1" => null,
            "purpose_of_remittance" => $user_recipient_details->reason_for_sending,
            "callback_url" => "",
            "retail_fee" => "",
            "retail_fee_currency" => "",
            "external_code" => "",
            "credit_party_identifier" => $credit_party_identifier,
            "additional_information_3" => "",
            "additional_information_2" => "",
            "external_id" => $external_id,
            "sender" => [
                "firstname" => $user_sender_details->first_name,
                "id_expiration_date" => "",
                "lastname" => $user_sender_details->last_name,
                "country_of_birth_iso_code" => "USA",
                "country_iso_code" => "USA",
                "source_of_funds" => "",
                "date_of_birth" => $user_sender_details->dob,
                "country_iso_code" => "USA",
                "beneficiary_relationship" => "",
                "nativename" => "",
                "id_country_iso_code" => "USA",
                "email" => "",
                "city" => $user_sender_details->city,
                "postal_code" => $user_sender_details->zip_code,
                "id_type" => "OTHER",
                "address" => $user_sender_details->address_line_1 . ' ' . $user_sender_details->address_line_2,
                "id_number" => strtotime(date('Y-m-d H:i:s')),
                "gender" => "",
                "code" => strtotime(date('Y-m-d H:i:s')),
                "id_delivery_date" => "",
                "middlename" => "",
                "occupation" => "",
                "province_state" => "",
                "msisdn" => ($user_sender_details->phone_no)?$user_sender_details->phone_no:"",
                "nationality_country_iso_code" => "USA"
            ],
            "beneficiary" => [
                "firstname" => $user_recipient_details->first_name,
                "bank_account_holder_name" => "",
                "id_expiration_date" => "",
                "lastname2" => "",
                "date_of_birth" => "",
                "country_iso_code" => $user_activity_details->receive_country,
                "lastname" => $user_recipient_details->last_name,
                "nativename" => "",
                "id_country_iso_code" => $user_activity_details->receive_country,
                "email" => "",
                "city" => $user_recipient_details->city,
                "postal_code" => "",
                "id_type" => "OTHER",
                "address" => $user_recipient_details->address,
                "id_number" => strtotime(date('Y-m-d H:i:s')),
                "gender" => "",
                "code" => "",
                "id_delivery_date" => "",
                "middlename" => "",
                "occupation" => "",
                "province_state" => "",
                "country_of_birth_iso_code" => $user_activity_details->receive_country,
                "msisdn" => $user_recipient_details->phone_no,
                "nationality_country_iso_code" => $user_activity_details->receive_country
            ]
        ];
        //print_r($post_data);
        $res = GeneralHelper::thunesAPI($url, $request_type, $post_data);
        //dd($res);
        $transaction_request = json_encode($post_data);
        if (isset($res->id)) {
            return $this->confirmTransaction($transaction_request, $external_id, $res->id);
        } else {
            //echo $errorMsg = $res->errors[0]->message;
            $errorMsg = $res->errors[0]->message;
            //return ['success'=>false, 'message'=>$errorMsg ];
            session(['error_msg' => $errorMsg]);
        }
    }

    public function confirmTransaction($transaction_request, $external_id, $transaction_id)
    {
        $url = 'transactions/' . $transaction_id . '/confirm';
        $request_type = 'POST';
        $post_data = ["external_id" => $external_id];
        $res = GeneralHelper::thunesAPI($url, $request_type, $post_data);
        //dd($res);
        if (isset($res->id)) {
            $user_id = Auth::user()->id;
            $obj_payment_trans = new UserPaymentTransaction();

            $sent_amount = $res->sent_amount->amount;
            $currency = $res->sent_amount->currency;

            $obj_payment_trans->user_id = $user_id;
            $obj_payment_trans->transaction_id = $res->id;
            $obj_payment_trans->fees = GlobalValues::get('fees');
            $obj_payment_trans->fees_currency = 'USD';
            $obj_payment_trans->sent_amount = $sent_amount;
            $obj_payment_trans->currency = $currency;
            $obj_payment_trans->receive_amount = $res->destination->amount;
            $obj_payment_trans->receive_currency = $res->destination->currency;
            $obj_payment_trans->purpose_of_remittance = $res->purpose_of_remittance;
            $obj_payment_trans->status = $res->status_class_message;
            $obj_payment_trans->transaction_request = $transaction_request;
            $obj_payment_trans->transaction_response = json_encode($res);
            $obj_payment_trans->save();

            //send notification to super admin
            $user = Auth::user();

            $notification = new Notification();
            $notification->from_id = $user_id;
            $notification->to_id = 1;
            $notification->transaction_id = $res->id;
            $notification->subject = 'Money Sent';
            $notification->description = $sent_amount. ' '.$currency.' received from '. $user->first_name. ' '.$user->last_name;
            $notification->save();

            $responseData = new Collection();
            $responseData->add([
                'txn_id' => $res->id,
                'sent_amount' => $sent_amount,
                'sent_currency' => $currency
            ]);

            //check user preferance to send email notification
            $user_preferance = UserPreference::where('user_id', $user_id)->first();
            if (isset($user_preferance) && $user_preferance->email_notification == '1') {
                $email = $user->email;
                if($email != "") {
                    $site_title = GlobalValues::get('site_title');
                    $site_email = GlobalValues::get('site_email');
                    $email_template_key = "transaction-detail";
                    $email_template_view = "emails.transaction-detail";
                    $email_template = EmailTemplateTrans::where("template_key", $email_template_key)->first();
                    $arr_keyword_values = array();

                    $arr_keyword_values['FIRST_NAME'] = $user->first_name;
                    $arr_keyword_values['LAST_NAME'] = $user->last_name;
                    $arr_keyword_values['FROM_AMOUNT'] = $sent_amount;
                    $arr_keyword_values['FROM_CURRENCY'] = $currency;
                    $arr_keyword_values['PAYMENT_METHOD'] = $res->payer->service->name;
                    $arr_keyword_values['PAYMENT_NAME'] = $res->payer->name;
                    $arr_keyword_values['TRANSACTION_DETAIL'] = url('/').'/receipt-details/'.$res->id;
                    $arr_keyword_values['SITE_TITLE'] = $site_title;
                    $arr_keyword_values['SITE_URL'] = url('/');
                    $job = (new SendEmailQueue($email_template_view, $arr_keyword_values, $email, $email_template->subject));
                    dispatch($job);
                }
            }

            return ['success' => true, 'responseData'=> $responseData, 'message' => "Transaction completed successfully."];
        } else {
            $errorMsg = $res->errors[0]->message;
            //return ['success'=>false, 'message'=>$errorMsg ];
            session(['error_msg' => $errorMsg]);
            return ['success' => false, 'responseData'=>[], 'message' => $errorMsg];
        }
    }

    public function getTransaction($transaction_id)
    {
        $url = 'transactions/' . $transaction_id;
        $request_type = 'GET';
        $res = GeneralHelper::thunesAPI($url, $request_type);
        dd($res);
    }
}
