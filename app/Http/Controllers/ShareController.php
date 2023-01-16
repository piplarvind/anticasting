<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmailShare;
use App\Http\Requests\StoreMobileShare;
use App\Helpers\GlobalValues;
use Piplmodules\Emailtemplates\Models\EmailTemplateTrans;
use Auth;
use App\Jobs\SendEmailQueue;
use Twilio\Rest\Client;
use App\Models\UserInformation;

class ShareController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $user_id = Auth::user()->id;
        $user_info = UserInformation::where(['user_id'=> $user_id])->first();
        $referralCode = $user_info->referral_code;
         // Share button
         $shareButtons = \Share::page(
            url('/').'?referal-code='.$referralCode,'Refer your friends and earn money'
      )
      ->facebook()
      ->whatsapp();

        return view('share')->with('shareButtons',$shareButtons )->with('referralCode',$referralCode);
    }

    public function emailShare(StoreEmailShare $request){
        if($request->validated()){
            $user = Auth::user();
            $user_info = UserInformation::where(['user_id'=> $user->id])->first();
            $referralCode = $user_info->referral_code;
            $site_title = GlobalValues::get('site_title');
            $site_email = GlobalValues::get('site_email');
            $email_template_key = "email-share";
            $email_template_view = "emails.email-share";
            $email_template = EmailTemplateTrans::where("template_key", $email_template_key)->first();
            
            $arr_keyword_values = array();
            $arr_keyword_values['USER_NAME'] = $user->first_name . " " . $user->last_name;
            $arr_keyword_values['FIRST_NAME'] = $user->first_name;
            $arr_keyword_values['LAST_NAME'] = $user->last_name;
            $arr_keyword_values['SHARE_LINK'] = url('/').'/register?referralCode='.$referralCode;
            $arr_keyword_values['SITE_TITLE'] = $site_title;
            $arr_keyword_values['SITE_URL'] = url('/');
            if ($user->email != ""){
                $job = (new SendEmailQueue($email_template_view, $arr_keyword_values, $user->email, $email_template->subject));
                dispatch($job);
            }
            return redirect("share")->with("alert-success", "Email sent successfully");
        }else{
            return redirect("share")->with("alert-danger", "Somethign went wrong");
        }   
    }

    public function mobileShare(StoreMobileShare $request){
        if($request->validated()){ 
            $user_id = Auth::user()->id;
            $user_info = UserInformation::where(['user_id'=> $user_id])->first();
            $referralCode = $user_info->referral_code;           
            $receiverNumber = '+'.$request->refer_mobile_no_phoneCode. $request->refer_mobile_no;
            $message = "Send money to your friend from ". GlobalValues::get('site_title');
            $message .= url('/').'/register?referralCode='.$referralCode;
            try {

                $account_sid = config('app.TWILIO_SID');    
                $auth_token = config('app.TWILIO_TOKEN');    
                $twilio_number = config('app.TWILIO_FROM');     
    
                $client = new Client($account_sid, $auth_token);    
                $client->messages->create($receiverNumber, [    
                    'from' => $twilio_number,     
                    'body' => $message]);   

                    return redirect("share")->with("alert-success", "SMS sent successfully");
            } catch (\Services_Twilio_RestException $e) {    
                //dd("Error: ". $e->getMessage());
                return redirect("share")->with("alert-danger", $e->getMessage());    
            }
        }else{
            return redirect("share")->with("alert-danger", "Somethign went wrong");
        }  
    }
}
