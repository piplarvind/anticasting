<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use App\Models\Otp;
use Carbon\Carbon;
use App\Notifications\NewUserNotification;
use Piplmodules\Sendinglimits\Models\Sendinglimit;
use App\Models\UserSubscription;
use App\Models\UserSubscriptionAttr;
use Piplmodules\Users\Models\UserPreference;
use Piplmodules\ReceivingCountry\Models\ReceivingCountry;

class AuthWebservicesController extends Controller
{


    public function mobileLogin(Request $request)
    {
        $credentials = $request->only('country_code', 'mobile_number');

        //valid credential
        $validator = Validator::make($credentials, [
            'country_code' => 'required',
            'mobile_number' => ['required', 'digits:10','numeric', 'regex:/^([0-9\s\-\+\(\)]*)$/']
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['success' => false,'validationMessage' => $validator->messages()], 200);
        }
        $country_code = trim($credentials['country_code'],"+");
        $user = User::with('userInformation')->where(['country_code' => $country_code,'mobile_number' => $credentials['mobile_number']])->first();
        
        if(isset($user)){
            if($user->account_status == "0"){
                return response()->json(['success' => false,'message' =>  __('Your account is in inactive state, please contact administrator')], 200);
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
            $otp->event_type = 'mobile-login-otp';
            $otp->expiry_date = $otp_expires_time;
            $otp->save();
                    
            //Token created, return with success response and jwt token
            return response()->json([
                'success' => true,
                'otp' => $otpVal,
				'otp_expire_in'=> 180
            ]);
        } else{
            $errorMsg = "Mobile number not found";
            return response()->json(['success'=> false, 'message' => $errorMsg]);
        }        
    }

    public function mobileLoginOTP(Request $request){
        $credentials = $request->only('country_code', 'mobile_number', 'otp');
        

        //valid credential
        $validator = Validator::make($credentials, [
            'otp' => 'required',
            'country_code' => 'required',
            'mobile_number' => ['required', 'digits:10','numeric', 'regex:/^([0-9\s\-\+\(\)]*)$/']
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['success' => false,'validationMessage' => $validator->messages()], 200);
        }

        $otp = Otp::where(['otp' => $credentials['otp'],'mobile_no' => $credentials['mobile_number'],'event_type' => 'mobile-login-otp'])->orderBy('id', 'desc')->first();
        
        if(isset($otp)){
            $otp_expires_time = Carbon::now();
            if($credentials['otp'] == $otp->otp){
                if(strtotime($otp_expires_time) > strtotime($otp->expiry_date)) {
                    return response()->json(['success' => false,'message' => 'OTP expired'], 200);
                }else{     
                    $user = User::where(['mobile_number' => $credentials['mobile_number']])->first();
                    if(isset($user)){
                        //$user->account_status = '1';
                        //$user->save();
                        if ($user->account_status == "1") {
                            //$token = strtotime(date("Y-m-d H:i:s"));
                            //Request is validated
                            //Create token
                            try {
                                
                                if (! $token = JWTAuth::fromUser($user)) {
                                    return response()->json([
                                        'success' => false,
                                        'message' => 'Invalid login credentials',
                                    ], 400);
                                }
                                $country_iso_code = $user->userInformation->send_money_to;
                                $country_info = ReceivingCountry::where('country_iso_code',$country_iso_code)->first();

                                $user['country_iso_code']= $country_iso_code;
                                $user['currency']= $country_info->currency;
                                $user['image_path']= url('/').'/public/country';
                                $user['flag']= $country_info->flag;
                                $user['country_name']= $country_info->country_name;
                                return response()->json(['success'=> true, 'message' => "", 'responseData' => $user, 'token' => $token]);
                            } catch (JWTException $e) {
                                //return $credentials;
                                return response()->json([
                                        'success' => false,
                                        'message' => 'Could not create token',
                                    ], 500);
                            }
                            
                        }elseif ($user->account_status == "0") {
                            $errorMsg = __('Your account has been blocked, please contact administrator');
                        } elseif ($user->account_status == "2") {
                            $errorMsg = __('Your account has been blocked , please contact administrator');
                        } elseif ($user->account_status == "3") {
                            $errorMsg = __('Your account has been suspended, please contact administrator');
                        }elseif ($user->account_status == "4") {
                            $errorMsg = __('Your account has been deleted, please contact administrator');
                        }
                                
                        //Token created, return with success response and jwt token
                        return response()->json([
                            'success' => true,
                            'token' => $token,
                        ]);
                    } else{
                        $errorMsg = "Invalid credentials";
                        return response()->json(['success'=> false, 'message' => $errorMsg]);
                    }
                    //return response()->json(['success' => true,'message' => 'OTP verified successfully', 'responseData' => $user], 200);
                }
            }else{
                return response()->json(['success' => false,'message' => 'Invalid OTP'], 200);
            }
        }else{
            return response()->json(['success' => false,'message' => 'Invalid OTP'], 200);
        }
    }

    public function emailLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:20'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['success' => false,'validationMessage' => $validator->messages()], 200);
        }

        $user = User::where(['email' => $credentials['email']])->first();
        
        if(isset($user)){
            if (!Hash::check($credentials['password'], $user->password)) {				
                $errorMsg = "Invalid credentials.";
                return response()->json(['success'=> false, 'message' => $errorMsg]);
            }
            if ($user->email_verified == 0) {
                $errorMsg = 'Email is not yet verified';
            } elseif ($user->account_status == "1") {
				//$token = strtotime(date("Y-m-d H:i:s"));
                //Request is validated
                //Create token
                try {
                    if (! $token = JWTAuth::attempt($credentials)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Login credentials are invalid',
                        ], 400);
                    }
                    $country_iso_code = $user->userInformation->send_money_to;
                    $country_info = ReceivingCountry::where('country_iso_code',$country_iso_code)->first();

                    $user['country_iso_code']= $country_iso_code;
                    $user['currency']= $country_info->currency;
                    $user['image_path']= url('/').'/public/country';
                    $user['flag']= $country_info->flag;
                    $user['country_name']= $country_info->country_name;

                    return response()->json(['success'=> true, 'message' => "", 'responseData' => $user, 'token' => $token]);
                } catch (JWTException $e) {
                    //return $credentials;
                    return response()->json([
                            'success' => false,
                            'message' => 'Could not create token',
                        ], 500);
                }
                
            }elseif ($user->account_status == "0") {
                $errorMsg = __('Account in not yet activated, please contact administrator');
            } elseif ($user->account_status == "2") {
                $errorMsg = __('Account has been blocked by administrator');
            } elseif ($user->account_status == "3") {
                $errorMsg = __('Account has been suspended by administrator');
            }elseif ($user->account_status == "4") {
                $errorMsg = __('Account has been deleted by administrator');
            }
                    
            //Token created, return with success response and jwt token
            return response()->json([
                'success' => false,
                'message' => $errorMsg
            ]);
        } else{
            $errorMsg = "Invalid credentials";
            return response()->json(['success'=> false, 'message' => $errorMsg]);
        }        
    }
 
    


    public function emailRegistration(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => ['required', 'string', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', 'max:255', 'unique:users,email'],
            'password' => 'required|string|min:8|max:20'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['success' => false,'validationMessage' => $validator->messages()], 200);
        }

        $activation_code = GeneralHelper::generateReferenceNumber();

        $user = new User();

        try{
            $user->email = $request->email;
            $user->activation_code = $activation_code;
            $user->password = Hash::make($request->password);
            $user->mobile_verified = 0;
            $user->account_status = '1';
            $user->email_verified = 1;
            $user->user_type = '2';
            $user->save();

            //save user preferance
            $user_preferences = new UserPreference();
            $user_preferences->user_id = $user->id;
            $user_preferences->email_notification = true;
            $user_preferences->save();

            //save user role
            \DB::table('users_roles')->insert([
                'role_id' => 3,
                'user_id'=> $user->id
            ]);

            $user_info = new UserInformation();
            $user_info->user_id = $user->id;
            $user_info->send_money_from = 'USA';//Default country to send money from country
            $user_info->send_money_to = 'MEX';//Default country to send money to country
            $user_info->referral_code = strtotime(date('Y-m-d H:i:s'));
            $user_info->friend_referral_code = ($request->referralCode)?$request->referralCode:null;
            $user_info->save();

            /**
             * Assign the default sending limit to user
             */
            $sendingLimit = Sendinglimit::where('id', 1)->first();

            if(isset($sendingLimit)){
                $userSubscription = new UserSubscription();
                $userSubscription->user_id = $user->id;
                $userSubscription->sending_limit_name = $sendingLimit->name;
                $userSubscription->save();

                $userSubscriptionAttr = new UserSubscriptionAttr();
                $userSubscriptionAttr->user_id = $user->id;
                $userSubscriptionAttr->user_subscription_id = $userSubscription->id;
                $userSubscriptionAttr->one_day_price = $sendingLimit->attrs->one_day_price;
                $userSubscriptionAttr->thirty_day_price = $sendingLimit->attrs->thirty_day_price;
                $userSubscriptionAttr->half_yearly_price = $sendingLimit->attrs->half_yearly_price;
                $userSubscriptionAttr->save();
            }

            $email = $request->email;
            if($email != "") {
                $site_title = GlobalValues::get('site_title');
                $site_email = GlobalValues::get('site_email');
                $email_template_key = "active-user";
                $email_template_view = "emails.active-user";
                $email_template = EmailTemplateTrans::where("template_key", $email_template_key)->first();
                $arr_keyword_values = array();

                $arr_keyword_values['FIRST_NAME'] = $user->first_name;
                $arr_keyword_values['LAST_NAME'] = $user->last_name;
                $arr_keyword_values['ACTIVATION_LINK'] = route('verify-user-email', $activation_code);
                $arr_keyword_values['SITE_TITLE'] = $site_title;
                $arr_keyword_values['SITE_URL'] = url('/');
                //$job = (new SendEmailQueue($email_template_view, $arr_keyword_values, $email, $email_template->subject));
                //dispatch($job);    
                return response()->json([
                    'success' => true,
                    'message' => 'You have registered successfully, please login'
                ]);  
            }
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be register '.$exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function fbRegistration(Request $request)
    {
        $credentials = $request->only('email');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => ['required', 'string', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', 'max:255', 'unique:users,email'],
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['success' => false,'validationMessage' => $validator->messages()], 200);
        }


        $user = new User();

        return response()->json([
            'success' => true,
            'message' => 'Please provide social medial input parameters'
        ]); 

        try{
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be register '.$exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function mobileRegistration(Request $request)
    {
        $credentials = $request->only('country_code', 'mobile_number');

        //valid credential
        $validator = Validator::make($credentials, [
            'country_code' => 'required',
            'mobile_number' => ['required','numeric', 'regex:/^([0-9\s\-\+\(\)]*)$/','unique:users,mobile_number']
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['success' => false,'validationMessage' => $validator->messages()], 200);
        }

        $activation_code = GeneralHelper::generateReferenceNumber();

        $user = new User();

        try{
            $user->country_code = $request->country_code;
            $user->mobile_number = $request->mobile_number;
            $user->activation_code = $activation_code;
            $user->password = Hash::make($request->password);
            $user->mobile_verified = 0;
            $user->account_status = '1';
            $user->email_verified = 1;
            $user->user_type = '2';
            $user->save();

            //save user preferance
            $user_preferences = new UserPreference();
            $user_preferences->user_id = $user->id;
            $user_preferences->email_notification = true;
            $user_preferences->save();

            //save user role
            \DB::table('users_roles')->insert([
                'role_id' => 3,
                'user_id'=> $user->id
            ]);

            $user_info = new UserInformation();
            $user_info->user_id = $user->id;
            $user_info->send_money_from = 'USA';//Default country to send money from country
            $user_info->send_money_to = 'MEX';//Default country to send money to country
            $user_info->referral_code = strtotime(date('Y-m-d H:i:s'));
            $user_info->friend_referral_code = ($request->referralCode)?$request->referralCode:null;
            $user_info->save();

            /**
             * Assign the default sending limit to user
             */
            $sendingLimit = Sendinglimit::where('id', 1)->first();

            if(isset($sendingLimit)){
                $userSubscription = new UserSubscription();
                $userSubscription->user_id = $user->id;
                $userSubscription->sending_limit_name = $sendingLimit->name;
                $userSubscription->save();

                $userSubscriptionAttr = new UserSubscriptionAttr();
                $userSubscriptionAttr->user_id = $user->id;
                $userSubscriptionAttr->user_subscription_id = $userSubscription->id;
                $userSubscriptionAttr->one_day_price = $sendingLimit->attrs->one_day_price;
                $userSubscriptionAttr->thirty_day_price = $sendingLimit->attrs->thirty_day_price;
                $userSubscriptionAttr->half_yearly_price = $sendingLimit->attrs->half_yearly_price;
                $userSubscriptionAttr->save();
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
            $otp->event_type = 'mobile-login-otp';
            $otp->expiry_date = $otp_expires_time;
            $otp->save();
                    
            //Token created, return with success response and jwt token
            return response()->json([
                'success' => true,
                'otp' => $otpVal,
				'otp_expire_in' => 180
            ]);
  
            return response()->json([
                'success' => true,
                'message' => 'You have registered successfully, OTP sent to verify the mobile number',
                'otp' => $otpVal
            ]);  
            
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be register '.$exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function forgotpassword(Request $request){
        $credentials = $request->only('email');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['success' => false,'validationMessage' => $validator->messages()], 200);
        }

        $user = User::where(['email' => $credentials['email']])->first();

        if(isset($user)){
            switch ($user->account_status) {
                case "0":
                    $response = 'Your account is not yet active, please contact administrator';
                    return response()->json(['success' => false,'message' => $response], 200);
                case "1":
                    $generate_token = app('auth.password.broker')->createToken($user);
                    $token = $generate_token;
                    $site_title = GlobalValues::get('site_title');
                    $site_email = GlobalValues::get('site_email');
                    $email_template_key = "forgot-password";
                    $email_template_view = "emails.forgot-password";
                    $email_template = EmailTemplateTrans::where("template_key", $email_template_key)->first();
                    $arr_keyword_values = array();
                    $arr_keyword_values['USER_NAME'] = $user->first_name . " " . $user->last_name;
                    $arr_keyword_values['FIRST_NAME'] = $user->first_name;
                    $arr_keyword_values['LAST_NAME'] = $user->last_name;
                    $arr_keyword_values['RESET_LINK'] = url('password/reset', $token) . '?email=' . urlencode($user->getEmailForPasswordReset());
                    $arr_keyword_values['SITE_TITLE'] = $site_title;
                    $arr_keyword_values['SITE_URL'] = url('/');
                    if ($user->email != ""){
                        $job = (new SendEmailQueue($email_template_view, $arr_keyword_values, $user->email, $email_template->subject));
                        dispatch($job);
                    }
                    $response = 'For your security, please look email from us to reset your password';
                    return response()->json(['success' => true,'message' => $response], 200);
                case "2":
                    $response = 'Your account is blocked by admin';
                    return response()->json(['success' => false,'message' => $response], 200);
                case "3":
                    $response = 'Your account is suspended by admin';
                    return response()->json(['success' => false,'message' => $response], 200);
                default:
                    $response = 'Unknown error';
                    return response()->json(['success' => false,'message' => $response], 200);
            }
        }else{
            $errorMsg = "We can not find user with this email";
            return response()->json(['success'=> false, 'message' => $errorMsg]);
        }
        
    }

    public function logout(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

		//Request is validated, do logout        
        try {
            JWTAuth::invalidate($request->token);
 
            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out '.$exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
