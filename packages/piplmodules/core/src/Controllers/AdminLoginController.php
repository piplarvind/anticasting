<?php
namespace Piplmodules\Core\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Piplmodules\Core\Requests\LoginRequest;
use Piplmodules\Users\Models\User;

class AdminLoginController extends Controller
{

 	/*
    |--------------------------------------------------------------------------
    | Piplmodules Admin login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles Admin login for the application.
    |
    */

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application login form.
     *
     * @return Response
     */
    public function getAdmin()
    {
        return view('Core::admin.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  LoginRequest  $request
     * @return Response
     */

    public function postAdmin(LoginRequest $request)
    {
        $this->validate($request, [
            $this->username() => 'required', 'password' => 'required',
        ]);
//        dd($request->all());
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        // $throttles = $this->isUsingThrottlesLoginsTrait();

        // if ($throttles && $this->hasTooManyLoginAttempts($request)) {
        if ($this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        // $credentials = $this->getCredentials($request);
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'email_verified' => 1,
            'account_status' => '1',
            'user_type' => '1'
        ];

//        dd($credentials);
        /*try{
            $abc = Auth::attempt($credentials, $request->has('remember'));
        }
        catch (Exception $e){
            echo $e->getMessage(); die;
        }*/

        if (auth()->attempt($credentials, $request->has('remember'))) {
//            return redirect('admin');
            request()->session()->flash('alert-class', 'alert-success');
            request()->session()->flash('message', 'Welcome back.');
            return redirect()->intended('admin/dashboard');
        } else {
            request()->session()->flash('alert-class', 'alert-danger');
            request()->session()->flash('message', 'Invalid email or password.');
            return back();
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.

        // if ($throttles) {
        //     $this->incrementLoginAttempts($request);
        // }

        return redirect('admin/login')
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => $this->getFailedLoginMessage(),
            ]);
    }

    /**
     * Log the user out of the application.
     *
     * @return Response
     */
    public function getFailedLoginMessage()
    {
        $message = trans('admin.auth_problem');

        return $message;
    }
}
