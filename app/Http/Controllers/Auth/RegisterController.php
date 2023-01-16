<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\UserInformation;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use GlobalValues;
use Mail;
use App\Jobs\SendEmailQueue;
use Session;
use Piplmodules\Emailtemplates\Models\EmailTemplateTrans;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewUserNotification;
use Piplmodules\Sendinglimits\Models\Sendinglimit;
use App\Models\UserSubscription;
use App\Models\UserSubscriptionAttr;
use Piplmodules\Users\Models\UserPreference;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm(Request $request) {
        $referralCode = $request->referralCode;
        return view('auth.register', compact('referralCode'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
            return Validator::make($data, [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'register_email' => ['required', 'string', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', 'max:255', 'unique:users,email'],
                'register_mobile_number' => ['required', 'digits:10','numeric', 'unique:users,mobile_number', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
                'full_number' => ['nullable'],
                'register_password' => ['required', 'string', 'min:8', 'confirmed'],
                'register_password_confirmation' => ['required', 'string', 'min:8']
            ],[
                'full_number.required'=>"Please select country code",
                'register_email.required'=>"The email field is required",
                'register_mobile_number.required'=>"The mobile field is required",
                'register_password.required'=>"The password field is required",
                'register_password_confirmation.required'=>"The confirm password field is required",
                
            ]);

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    /*protected function create(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }*/

    protected function register(Request $request) {
        //dd($request->all());
        $this->validator($request->all())->validate();

        $activation_code = GeneralHelper::generateReferenceNumber();

        $user = new User();

        $countryCode = str_replace($request->register_mobile_number,"", $request->full_number);

        $user->name = $request->first_name.' '.$request->last_name;
        $user->email = $request->register_email;
        $user->activation_code = $activation_code;
        $user->password = Hash::make($request->register_password);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->country_code = $countryCode;
        $user->mobile_number = $request->register_mobile_number;
        $user->mobile_verified = 1;
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

            $admins = User::where('id', 100001)->get();

            //Notification::send($admins, new NewUserNotification($user));

            /*@Mail::send($email_template_view, $arr_keyword_values, function ($message) use ($email, $user, $email_template, $site_email, $site_title) {
                $message->to($email, $user->first_name)->subject($email_template->subject)->from($site_email, $site_title);
            });*/
        }


        request()->session()->flash('alert-success', 'You have registered successfully, please login');
        request()->session()->flash('show_login_popup', 'yes');
        return redirect('/');
    }

    public function showOTP(Request $request){
        $otp = $request->otp;
        return view('auth.otp', compact('otp'));
    }

    public function verifyOtp(Request $request){
        $otp = $request->otp;
        $current_datetime = now();
        $otp_data = Otp::where(['otp'=>$otp])->orderBy('id', 'desc')->first();

        if(empty($otp_data)){
            return response()->json(['errorCode' => 0, 'msg' => 'Invalid OTP.']);
        }
        if(strtotime($otp_data->expiry_date) < strtotime($current_datetime)){
            return response()->json(['errorCode' => 0, 'msg' => 'OTP expired.']);
        }

        $user_info = User::where(['mobile_number' => $otp_data->mobile_no])->first();
        Session::put('user_id', $user_info->id);

        $user_info->mobile_verified = 1;
        $user_info->save();
        return response()->json(['errorCode' => 1, 'msg' => 'OTP verified successfully.']);
    }


    protected function verifyUserEmail($activation_code) {
        $user_activation = User::where('activation_code', $activation_code)->first();

        if ($user_activation) {
            //$user_activation->activation_code = '';
            $user_activation->account_status = '1';
            $user_activation->email_verified = 1;
            $user_activation->email_verified_at = now();
            $user_activation->save();


            request()->session()->flash('alert-success', "Congratulations! your account has been activated successfully. Please login to continue...");

            return redirect("login");
        }
    }
}
