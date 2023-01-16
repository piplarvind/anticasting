<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailQueue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Piplmodules\Contactus\Models\ContactUs;
use Piplmodules\Emailtemplates\Models\EmailTemplateTrans;
use App\Helpers\GlobalValues;

class ContactUsController extends Controller
{

    public function index()
    {
        return view('contact-us');
    }

    public function submitContact(Request $request)
    {
        $this->validate($request, [
            'contact_first_name' => 'required|string',
            'contact_last_name' => 'required|string',
            'contact_email' => 'required|string|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'contact_phone_number' => 'required|string',
            'contact_msg_content' => 'required|string',
            'g-recaptcha-response' => 'required|captcha'
        ],
            [
                'contact_first_name.required' => 'Please enter first name',
                'contact_last_name.required' => 'Please enter last name',
                'contact_email.required' => 'Please enter email',
                'contact_email.email' => 'Please enter valid email',
                'contact_phone_number.required' => 'Please enter phone number',
                'contact_msg_content.required' => 'Please enter your text',
                'g-recaptcha-response.required' => 'Captcha field is require'
            ]);
        $contact = new ContactUs();
        $contact->first_name = $request->contact_first_name;
        $contact->last_name = $request->contact_last_name;
        $contact->email = $request->contact_email;
        $contact->phone_number = $request->contact_phone_number;
        $contact->phone_code = $request->contact_phone_number_phoneCode;
        $contact->msg_content = $request->contact_msg_content;
        $contact->save();

        $email = $request->email;
        if ($email != "") {
            $site_title = GlobalValues::get('site_email');
            $site_email = GlobalValues::get('contact_email');
            $email_template_key = "user-contacted";
            $email_template_view = "emails.user-contacted";
            $email_template = EmailTemplateTrans::where("template_key", $email_template_key)->first();

            $arr_keyword_values = array();

            //Assign values to all macros
            $arr_keyword_values['USERNAME'] = $request->first_name. ' '. $request->last_name;
            $arr_keyword_values['MESSAGE'] = $request->msg_content;
            $arr_keyword_values['CONTACT_DATE'] = date("jS F Y h:i:s A");
            $arr_keyword_values['SITE_TITLE'] = $site_title;
            $arr_keyword_values['SITE_URL'] = url('/');

            $admin_user = User::where('id',1)->first();

            /*@Mail::send($email_template_view, $arr_keyword_values, function ($message) use ($request, $site_email, $site_title, $email_template) {
                $message->from($request->email, $request->first_name. ' '. $request->last_name);
                $message->to($site_email);
                $message->subject($email_template->subject);
            });*/


            $job = (new SendEmailQueue($email_template_view, $arr_keyword_values, $site_email, $email_template->subject));
            dispatch($job);
        }

        $errorMsg = "Thank you for contacting us! We will get back to you soon";

        return redirect()->route('contact-us')->with("alert-success", $errorMsg);
    }

}
