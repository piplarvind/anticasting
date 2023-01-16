<?php
namespace Piplmodules\Contactus\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailQueue;
use Illuminate\Http\Request;
use Piplmodules\Contactus\Models\ContactUs;
use Piplmodules\Emailtemplates\Models\EmailTemplateTrans;
use Piplmodules\Contactus\Models\ContactusReply;
use Illuminate\Support\Facades\Input;
use Auth;
use Lang;
use Piplmodules\Settings\Models\Setting;
use Validator;
use Illuminate\Support\Facades\URL;
use Config;
use Illuminate\Support\Facades\Mail;

class ContactUsApiController extends Controller
{
    /**
     * @param
     * @return
     */
    public function validatation($request)
    {
        $languages = config('uistacks.locales');
        $rules['page_url'] = 'unique:pages';
        $rules = [];
        if(count($languages)) {
            foreach ($languages as $key => $language) {
                $code = $language['code'];
                if($request->language){
                    foreach($request->language as $lang){
                        $rules['name_'.$code.''] = 'required|max:40';
                    }
                }
            }
        }
        return \Validator::make($request->all(), $rules);
    }

    /**
     *list item
     */
    public function listItems(Request $request)
    {
        $contactrequest = ContactUs::FilterStatus()->orderBy('id', 'DESC')->paginate($request->get('paginate'));
        return $contactrequest;
    }

    public function postReply(Request $request, $id) {
        $contact = ContactUs::find($id);
        if (isset($contact)) {
            $contact->is_read = 1;
            $contact->is_reply = 1;
            $contact->replied_at = date('Y-m-d H:i:s');
            $contact->save();

            $objReply = new ContactusReply();
            $objReply->contact_id = $id;
            $objReply->reply_msg = $request->message;
            $objReply->save();

            $site_title = Setting::find(1)->value;
            //$site_email = Setting::find(2)->value;
            $arr_keyword_values = array();
            $arr_keyword_values['USERNAME'] = $contact->first_name. ' '. $contact->last_name;
            $arr_keyword_values['MESSAGE'] = $request->message;
            $arr_keyword_values['SITE_TITLE'] = $site_title;
            $arr_keyword_values['SITE_URL'] = url('/');

            $email_template_key = "admin-contacted";
            $email_template_view = "emails.admin-contacted";
            $email_template = EmailTemplateTrans::where("template_key", $email_template_key)->first();

            $job = (new SendEmailQueue($email_template_view, $arr_keyword_values, $contact->email, $email_template->subject));
            dispatch($job);
            session()->flash('alert-success', 'Reply posted successfully!');
           return redirect()->route('admin.contact-us.view-msg', [$id]);

        } else {
            return redirect()->route('admin.contact-us.view-msg', [$id]);
        }
return true;
    }



}