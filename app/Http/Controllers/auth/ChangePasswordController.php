<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use  App\Rules\MatchOldPassword;
use Hash;

class ChangePasswordController extends Controller
{
    //
    public function changePassword(){

        return view('auth.change_password');
    }
    public function changePasswordPost(Request $request){
       
       // dd($request);
        $request->validate([

             'oldpassword'=>['required','string','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/','min:8'],
             'password'=>['required','string','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/','min:8'],
             'confirm_password'=>['required','same:password'],
           
        ]);
      
           if(auth()->check()){

             if(auth()?->user()?->user_type=='0')
             {
             // dd($request);
               if(!Hash::check($request->oldpassword,auth()?->user()?->password)){
                 
                  return redirect()->back()->with('error',' Old Password does not match.');
                //return redirect()->route('user.home')->with('message','Password changed successfully.');
               }
               User::whereId(auth()->user()->id)->update([
                  'password'=>Hash::make($request->password)
               ]);
               return redirect()->route('users.home')->with('message','Password Changed.');
            }
          }
     
    }
}
