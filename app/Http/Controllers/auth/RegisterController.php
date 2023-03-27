<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Helpers\GeneralHelper;
use App\Models\{User, Otp};
use Carbon\Carbon;
use Hash;
use Mail;
use Session;

class RegisterController extends Controller
{
    //
    public function register()
    {
        return view('auth.register');
    }

    public function validateUserEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first('email');
        if ($user) {
            $return = false;
        } else {
            $return = true;
        }
        echo json_encode($return);
        exit();
    }

    public function validateUserMobileNumber(Request $request)
    {
      $user = User::where('mobile_no', $request->mobile_no)->first('mobile_no');
        if ($user) {
            $return = false;
        } else {
            $return = true;
        }
        echo json_encode($return);
        exit();
    }
    public function submitRegister(Request $request)
    {
         
         $request->validate(
            [
                'first_name' => ['required'],
                'last_name' => ['required'],
                'email' => ['required', 'email', 'unique:users'],
                'mobile_no' => ['required'],
                // 'password'=>['required','string','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/','min:8'],
                'password' => [
                    'required',
                    'string',
                    'min:8', // must be at least 10 characters in length
                    'regex:/[a-z]/', // must contain at least one lowercase letter
                    'regex:/[A-Z]/', // must contain at least one uppercase letter
                    'regex:/[0-9]/', // must contain at least one digit
                    'regex:/[@$!%*#?&]/', // must contain a special character
                ],
                'confirm_password' => ['required', 'string', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/', 'min:8', 'same:password'],
            ],
            [
                'first_name.required' => 'Please enter first name',
                'last_name.required' => 'Please enter last name',
                'email.required' => 'Please enter email',
                'mobile_no.required' => 'Please enter mobile number',
                'password.required' => 'Please enter password',
                'confirm_password.required' => 'Please enter confirm password',
                // 'password.regex' => 'Password must be at least one specific symbols,one number and one capital letter,one small letter',
                'confirm_password.regex' => 'Confirm password must be at least one specific,one number symbols and one capital letter,one small letter',
                // 'password.min' => 'Password must be at least 8 character',
                'confirm_password.min' => 'Confirm Password must be at least 8 character',
            ],
        );
        $activation_code = GeneralHelper::generateReferenceNumber();
        $mobileNumber = str_replace(' ', '', $request->mobile_no);
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->password = Hash::make($request->password);
        $user->mobile_no = $mobileNumber;
        $user->countryCode =  $request->iso2;
        $user->activation_code = $activation_code;
        $user->email = $request->email;
        $user->status = 1;
        $user->user_type = '0';
        $user->save();

        /* Otp */
        $digits = 4;
        $otp = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        $user_otp = new Otp();
        $user_otp->mobile_code = '91';
        $user_otp->mobile_no = $mobileNumber;
        $user_otp->otp = $otp;
        $user_otp->expiry_date = Carbon::now()->addMinutes(10);
        $user_otp->save();
        Mail::send('emails.email_show_otp', ['Firstname' => $user->first_name, 'Lastname' => $user->last_name, 'email' => $user->email, 'otp' => $user_otp->otp], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Anticasting');
        });
        //  dd("Registeration");
        // return redirect()
        //     ->route('users.login')
        //     ->with('message', 'Register successfully done.');
        return redirect('/showotp/');
    }
    public function showOtp(Request $request)
    {
        return view('auth.otp');
    }
    public function VerifyOtp(Request $request)
    {
        $request->validate(
            [
                'otp' => 'required',
            ],
            [
                'otp.required' => 'Please enter valid otp.',
            ],
        );
        $otp = $request->otp;

        $current_datetime = now();
        $otp_data = Otp::where(['otp' => $otp])
            ->orderBy('id', 'desc')
            ->first();
        if ($otp_data == null) {
            return redirect()
                ->back()
                ->with('invalid', 'Otp Invalid.');
        }
        if (strtotime($otp_data->expiry_date) < strtotime($current_datetime)) {
            return redirect()
                ->back()
                ->with('expire', 'Otp Expired.');
        }
        $user_info = User::where(['mobile_no' => $otp_data->mobile_no])->first();

        // Session::put('user_id', $user_info->id);

        $user_info->mobile_verified = 1;
        $user_info->save();
        return redirect()
            ->route('users.login')
            ->with('success', 'Otp Verified Successful.');
    }
}
