<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\Models\User;
use Mail;
use Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    //
    public function showForgotPassword()
    {

        return view('auth.forgotpassword');
    }
    public function submitForgotPassword(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:users',
        ]);
        $token = mt_rand(00000000,99999999);
        $email = $request->email;
        // dd($token);
        DB::table('password_resets')->where('email', $request->email)->delete();
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()->format('Y-m-d')
        ]);

        Mail::send('emails.forget-password', ['token' => $token,'email'=>$email ], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
       
        });
        return back()->with('message', 'We have e-mailed your password reset link!');
    }
    public function ResetPassword($token,$email)
    {

        return view('auth.resetpassword', ['token' => $token,'email'=>$email]);
    }
    public function submitResetPassword(Request $request)
    {
        
        $request->validate([
          
            'password' => 'required|string|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'confirm_password' => 'required|same:password'
        ]);

        $updatePassword = DB::table('password_resets')->where('token',$request->token)->first();
         
        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token!');
        }
        
        $user = User::where('email', $request->email)->first();
       // dd( $request->email);
        $user->password =  Hash::make($request->password);
        $user->save();  

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return redirect()->route('users.login')->with('message', 'Your password has been changed!');
    }
}