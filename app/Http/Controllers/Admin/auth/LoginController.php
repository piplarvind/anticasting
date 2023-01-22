<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class LoginController extends Controller
{
    //
    public function login()
    {
        return view('admin.auth.login');
    }
    public function loginSubmit(Request $request)
    {
        $request->validate(
            [
                'email' => 'required',
                'password' => ['required','string','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/','min:8'],
                //'password' => ['required'],
            ],
            [
                'email.required' => 'Please enter registerd email',
                'password.required' => 'Please enter password',
                'password.regex'=>'Password must be at least one specific symbols,one number and one capital letter,one small letter',
                'password.min'=>'Password must be at least 8 character',
            ],
        );
        
        $credentials = $request->only(['email', 'password']);
       
        if (auth()->attempt($credentials)) {
            if (auth()?->user()?->user_type == '1') {
             
                
                return redirect()
                    ->route('admin.dashboard')
                    ->with('message', 'Login successfully.');
            }
        }
        //    dd('unLogin');
        return redirect()
            ->back()
            ->with('error', 'email and password incorrect.');
    }
    public function logoutAdmin()
    {
       
        \Auth::logout();
        return redirect()->route('admin.login');
    }
}
