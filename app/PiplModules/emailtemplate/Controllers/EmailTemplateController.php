<?php

namespace App\PiplModules\emailtemplate\Controllers;

use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\PiplModules\emailtemplate\Models\EmailTemplate;
use Validator;
use Datatables;
use Illuminate\Support\Str;

/**
 * Class EmailTemplateController
 * @package App\PiplModules\emailtemplate\Controllers
 */
class EmailTemplateController extends Controller
{
    /**
     * EmailTemplateController constructor.
     */
    public function __construct()
    {
        \App::setLocale('en');
        /*if (!Auth::check()) {
            $successMsg = "Session has been expired, please login.";
            return redirect("admin/login")->with("register-success", $successMsg);
        }*/
    }

    /**
     * @description This function is used to show email template view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view("emailtemplate::list");
    }

    /**
     * @description This function is used to get email template details
     * @return mixed
     */
    public function getEmailTemplateData()
    {
        $locale = config('app.locale');
        $all_templates = EmailTemplate::where('locale', $locale)->where('status', '1')->get();
        $i = 0;
        foreach ($all_templates as $template) {
            $date = Carbon::createFromTimeStamp(strtotime($template->created_at))->format('m-d-Y H:i A');
            $all_templates[$i]['posted_date'] = $date;
            $i++;
        }
        return Datatables::of($all_templates)
            ->addColumn("posted_date", function ($email_page) {
                return $email_page->posted_date;
            })
            ->addColumn('Language', function ($country) {
                $language = '<div class="td_content"><div class="custom_select"><select onchange="selectCountryLang(this)" data-placeholder="Choose a Language...">';
                $language .= '<option value="" disabled selected>Select Language</option>';
                if (count(config("translatable.locales_to_display"))) {
                    foreach (config("translatable.locales_to_display") as $locale => $locale_full_name) {
                        if ($locale != 'en') {
                            $language .= '<option id="' . $country->template_key . '" value="' . $locale . '">' . $locale_full_name . '</option>';
                        }
                    }
                }
                return $language;
            })
            ->make(true);
    }

    /**
     * @description This function is used to update the email template details
     * @param Request $request
     * @param $template_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function showUpdateEmailTemplateForm(Request $request, $template_id)
    {
        $email_template = EmailTemplate::find($template_id);

        if ($email_template) {
            if ($request->method() == "GET") {
                return view("emailtemplate::edit", ["template_info" => $email_template]);
            } else {
                $data = $request->all();
                $validate_response = Validator::make($data, array(
                    'subject' => 'required',
                    'html_content' => 'required',
                ));

                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                } else {
                    $file = htmlspecialchars_decode($request->input('html_content'));
                    // update it				
                    $email_template->subject = ($request->input('subject'));
                    $email_template->html_content = ($file);
                    $email_template->save();

                    // create view
                    $file_name = $email_template->template_key . ".blade.php";
                    $view_location = __DIR__ . "/../Views/" . $file_name;
                    $view_resource = fopen($view_location, "w+");
                    fwrite($view_resource, $email_template->html_content);
                    fclose($view_resource);
//                    \File::copy($view_location, base_path('etrio_app/resources/views/emails/' . $file_name));
                    return redirect("/admin/email-templates/list")->with('status', 'Email contents has been updated Successfully!');
                }
            }
        } else {
            return redirect("/admin/email-templates/list");
        }
    }

    /**
     * @description This function is used to update the email template details related to language
     * @param Request $request
     * @param $page_id
     * @param $locale
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function showUpdateEmailTemplateLanguageForm(Request $request, $page_id, $locale)
    {
        //dd($page_id);
        $page_id = substr($page_id, 0, -2) . 'hi';
        if (Str::endsWith($page_id ,'-hi') !== false) {
            if (strpos($page_id, '-hi') === false) {
                $page_id .= '-hi';
            }
        }
        $email_template = EmailTemplate::where('template_key', $page_id)->where('locale', $locale)->first();
        if ($email_template) {
            if ($request->method() == "GET") {
                return view("emailtemplate::edit", ["template_info" => $email_template]);
            } else {
                $data = $request->all();
                $validate_response = Validator::make($data, array(
                    'subject' => 'required',
                    'html_content' => 'required',
                ));

                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                } else {
                    $file = htmlspecialchars_decode($request->input('html_content'));
                    // update it				
                    $email_template->subject = ($request->input('subject'));
                    $email_template->html_content = ($file);
                    $email_template->save();

                    // create view
                    $file_name = $email_template->template_key . ".blade.php";
                    $view_location = __DIR__ . "/../Views/" . $file_name;
                    $view_resource = fopen($view_location, "w+");
                    fwrite($view_resource, $email_template->html_content);
                    fclose($view_resource);
//                    \File::copy($view_location, base_path('etrio_app/resources/views/emails/' . $file_name));
                    return redirect("/admin/email-templates/list")->with('status', 'Email contents has been updated Successfully!');
                }
            }
        } else {
            return redirect("/admin/email-templates/list");
        }
    }

    /**
     * @description This function is used to show details in modal
     * @param Request $request
     * @param $template_key
     * @param $locale
     */
    public function getTemplateView(Request $request, $template_key, $locale)
    {
        $email_template = null;
        $data = "";
        if ($locale == 'en') {
            $email_template = EmailTemplate::where('template_key', $template_key)->where('locale', $locale)->first();
        } else {
            $template_key = str_replace('-en', '-hi', $template_key);
            if (Str::endsWith($template_key ,'-hi') !== false) {
                if (strpos($template_key, '-hi') === false) {
                    $template_key .= '-hi';
                }
            }
            $email_template = EmailTemplate::where('template_key', $template_key)->where('locale', $locale)->first();
        }
        if (isset($email_template))
            $data = isset($email_template->html_content) ? $email_template->html_content : '';

        echo $data;
        exit();
    }

}
