<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session;
//use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    //
    public function login()
    {
        return view('auth.login');
    }
    public function submitLogin(Request $request)
    {
        //dd($request);
        $request->validate([
            'email' => 'required',
            'password' => ['required', 'string', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/', 'min:8'],
        ]);
        $credentials = $request->only(['email', 'password']);
        $remember_me = $request->has('remeber_me') ? true : false;
       
        // dd($credentials);
        if (auth()->attempt($credentials,$remember_me)) {
            if (auth()?->user()?->status == '0') {
                return redirect()
                    ->route('users.login')
                    ->with('error', 'Your account is not activated yet, please activate your account and try again.');
            }
            if (auth()?->user()?->user_type == '0') {
              
                return redirect()
                    ->route('users.home')
                    ->with('message', 'Login successfully.');
            }
        }
        //    dd('unLogin');
        return redirect()
            ->back()
            ->with('error', 'Email or password incorrect.');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('users.login');
    }
}
