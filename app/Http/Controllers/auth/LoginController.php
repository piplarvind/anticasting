<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
//use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{

    //
    public function login(){

        return view('auth.login');
    }
    public function submitLogin(Request $request)
    {
        //dd($request);
        $request->validate([
            
           
            'email'=>'required',
            'password'=>['required','string','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/','min:8'],
        ]);
        $credentials =   $request->only(['email','password']);
        // dd($credentials);
         if(auth()->attempt($credentials))
         {
             if(auth()?->user()?->user_type=='0'){
                  //dd('Login');
                 return redirect()->route('users.home')->with('message', 'Login successfully.');
             }
           
         }
     //    dd('unLogin');
         return redirect()->back()->with('error', 'email and password incorrect.');
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('users.login');
    }
}
