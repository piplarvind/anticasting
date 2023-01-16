<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use GlobalValues;
use Mail;
use Session;
use Piplmodules\Emailtemplates\Models\EmailTemplateTrans;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    //use SendsPasswordResetEmails;
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {

        return view('auth.passwords.email');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);



        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        /*$response = $this->broker()->sendResetLink(
            $request->only('email'));*/




        $user = \App\Models\User::where('email',$request->forgot_email)->first();

        if(isset($user))
        {

            switch ($user->account_status) {
                case "0":
                    $response = 'Your account is not active.';
                    return $this->sendResetLinkFailedResponse($request, $response);
                case "1":
                    $generate_token = app('auth.password.broker')->createToken($user);
                    $token = $generate_token;
                    $site_title = GlobalValues::get('site_title');
                    $site_email = GlobalValues::get('site_email');
                    $email_template_key = "forgot-password";
                    $email_template_view = "emails.forgot-password";
                    $email_template = EmailTemplateTrans::where("template_key", $email_template_key)->first();
                    $arr_keyword_values = array();
                    $arr_keyword_values['USER_NAME'] = $user->first_name . " " . $user->last_name;
                    $arr_keyword_values['FIRST_NAME'] = $user->first_name;
                    $arr_keyword_values['LAST_NAME'] = $user->last_name;
                    $arr_keyword_values['RESET_LINK'] = url('password/reset', $token) . '?email=' . urlencode($user->getEmailForPasswordReset());
                    $arr_keyword_values['SITE_TITLE'] = $site_title;
                    $arr_keyword_values['SITE_URL'] = url('/');
                    if ($user->email != ""){
                        $job = (new SendEmailQueue($email_template_view, $arr_keyword_values, $user->email, $email_template->subject));
                        dispatch($job);
                        /*@Mail::send($email_template_view, $arr_keyword_values, function ($message) use ($user, $email_template, $site_email, $site_title) {
                            $message->to($user->email, $user->first_name . " " . $user->last_name)->subject($email_template->subject)->from($site_email);
                        });*/
                    }
                    $response = 'For your security, please look an email from us to reset your password';
                    return $this->sendResetLinkResponse($response);
                case "2":
                    $response = 'Your account is blocked by admin';
                    return $this->sendResetLinkFailedResponse($request, $response);
                case "3":
                    $response = 'Your account is suspended by admin';
                    return $this->sendResetLinkFailedResponse($request, $response);
                default:
                    $response = 'Unknown error';
                    return $this->sendResetLinkFailedResponse($request, $response);
            }
        }
        else
        {
            $response = 'We can not find user with this email';
            return $this->sendResetLinkFailedResponse($request, $response);
        }

        /*$response = $this->broker()->sendResetLink(
            $request->only('email')
        );*/

        /*return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($response)
                    : $this->sendResetLinkFailedResponse($request, $response);*/
    }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $this->validate($request, ['forgot_email' => 'required|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix']);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse($response)
    {
        return back()->with('alert-success', trans($response));
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()->withErrors(
            ['forgot_email' => trans($response)]
        );
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }
}
