<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Hash;
class RegisterController extends Controller
{
    //
    public function register(){

        return view('auth.register');
    }
    public function submitRegister(Request $request)
    {
        // dd($request);
        $request->validate([
            
            'first_name'=>['required'],
            'last_name'=>['required'],
            'email'=>['required','email','unique:users'],
            'moblie_number'=>['required'],
            'password'=>['required','string','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/','min:8'],
            'confirm_password'=>['required','string','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/','min:8','same:password'],
            'gender'=>'required',
            'DateOfBirth'=>'required',
            
        ]);
        $user = new User();
        $user->first_name = $request->first_name; 
        $user->last_name = $request->last_name; 
        $user->password =  Hash::make($request->password); 
        $user->mobile_no = $request->moblie_number; 
        $user->gender = $request->gender; 
        $user->date_of_birth = Carbon::make($request->DateOfBirth)->format('Y-m-d'); 
        $user->email = $request->email; 
        $user->status = 1; 
        $user->user_type= '0';
        $user->save();
        return redirect()->route('users.login')->with('message',"Register successfully done.");
    }
}
