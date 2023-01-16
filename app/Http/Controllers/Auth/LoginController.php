<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserInformation;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\Models\Otp;
use Carbon\Carbon;
use Session;
use App\Models\UserActivityDetails;

class LoginController extends Controller
{

    protected $maxAttempts = 3; // Default is 5
    protected $decayMinutes = 30; // Default is 1
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm() {
        session(['link' => url()->previous()]);
        return view('auth.login');

    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request) {

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {

            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }



        if ($this->attemptLogin($request)) {

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request) {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request) {
        $remember = false;
        if(isset($request->remember))
            $remember = true;
        return $this->guard()->attempt(
            $this->credentials($request),$remember);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request) {

        return $request->only($this->username(), 'password');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request) {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user()) ?: redirect()->intended($this->redirectPath());
    }

    protected function authenticated(Request $request, $user)
    {
        $user_info = UserInformation::where(['user_id'=> Auth::user()->id])->first();

        if (Auth::user()->user_type == '1') {
            if (Auth::user()->account_status == "1") {
                return redirect("admin/dashboard");
            } elseif (Auth::user()->account_status == "0") {
                $errorMsg = "We found your account is not yet verified";
            } elseif (Auth::user()->account_status == "2") {
                $errorMsg = "We apologies, your account is blocked by administrator. Please contact to administrator for further details";
            }
            Auth::logout();
            return redirect("/admin/login")->with("alert-danger", $errorMsg);
        } elseif (Auth::user()->user_type == '2') {

            if (Auth::user()->email_verified == 0) {
                $errorMsg = "We found your email is not yet verified";
            }elseif (Auth::user()->account_status == '1') {
                $user_id = Auth::user()->id;
                $user_activity = UserActivityDetails::where(['user_id' => $user_id])->first();
                return redirect('edit-profile');

            }elseif (Auth::user()->account_status == '0') {
                $errorMsg = "We apologies, your account is inactive by administrator. Please contact to administrator for further details";
            } elseif (Auth::user()->account_status == '2') {
                $errorMsg = "We apologies, your account is blocked by administrator. Please contact to administrator for further details";
            } elseif (Auth::user()->account_status == '3') {
                $errorMsg = "We apologies, your account is suspended by administrator. Please contact to administrator for further details";
            }elseif (Auth::user()->account_status == '4') {
                $errorMsg = "We apologies, your account is deleted by administrator. Please contact to administrator for further details";
            }
            Auth::logout();
            return redirect("login")->with("alert-danger", $errorMsg);

        }
        // he is not admin. check whether he has activated, ask him to verify the account, otherwise forward to profile page.
        else {
            if (Auth::user()->account_status == "1") {
                if (Auth::user()->user_type == "1") {
                    return redirect("admin/dashboard");
                } else {
                    return redirect('edit-profile');
                }
            } elseif (Auth::user()->account_status == "0" || Auth::user()->account_status == "2") {
                // some issue with the account activation. Redirect to login page.
                $is_register = $request->session()->pull('is_sign_up');
                if (Auth::user()->account_status == "0") {
                    if ($is_register) {
                        $successMsg = "Congratulations! your account is successfully created. We have sent email verification email to your email address. Please verify";
                        Auth::logout();
                        return redirect("login")->with("register-success", $successMsg);
                    } else {
                        $errorMsg = "We found your account is not yet verified";
                    }
                } else {
                    $errorMsg = "We apologies, your account is blocked by administrator. Please contact to administrator for further details";
                }
                Auth::logout();
                return redirect("login")->with("alert-danger", $errorMsg);
            }
        }

    }

    public function logout(Request $request)
    {

        if (Auth::user()->user_type == "2") {
            $this->guard()->logout();
            $request->session()->flush();
            $request->session()->regenerate();
            //return redirect('/');
            return redirect("login")->with("alert-success", "You have successfully logout");
        }else{
            $this->guard()->logout();
            $request->session()->flush();
            $request->session()->regenerate();
            return redirect('/admin/login');
        }

    }
}
