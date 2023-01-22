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
    public function register()
    {
        return view('auth.register');
    }
    public function submitRegister(Request $request)
    {
        // dd($request);
        $request->validate(
            [
                'first_name' => ['required'],
                'last_name' => ['required'],
                'email' => ['required', 'email', 'unique:users'],
                'moblie_number' => ['required'],
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
                'gender' => 'required',
                'DateOfBirth' => 'required',
            ],
            [
                'first_name.required' => 'Please enter first name',
                'last_name.required' => 'Please enter last name',
                'email.required' => 'Please enter email',
                'moblie_number.required' => 'Please enter mobile number',
                'password.required' => 'Please enter password',
                'confirm_password.required' => 'Please enter confirm password',
                'gender.required' => 'Please enter gender',
                'DateOfBirth.required' => 'Please enter date Of birth',
                // 'password.regex' => 'Password must be at least one specific symbols,one number and one capital letter,one small letter',
                'confirm_password.regex' => 'Confirm password must be at least one specific,one number symbols and one capital letter,one small letter',
                // 'password.min' => 'Password must be at least 8 character',
                'confirm_password.min' => 'Confirm Password must be at least 8 character',
            ],
        );
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->password = Hash::make($request->password);
        $user->mobile_no = $request->moblie_number;
        $user->gender = $request->gender;
        $user->date_of_birth = Carbon::make($request->DateOfBirth)->format('Y-m-d');
        $user->email = $request->email;
        $user->status = 1;
        $user->user_type = '0';
        $user->save();
        return redirect()
            ->route('users.login')
            ->with('message', 'Register successfully done.');
    }
}
