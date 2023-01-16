<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreRecipientDetails;
use App\Models\UserRecipientDetails;
use Image;
use App\Models\UserActivityDetails;
use App\Helpers\GlobalValues;
use App\Helpers\GeneralHelper;
use Piplmodules\ReceivingCountry\Models\ReceivingCountry;
use Response;
use App\Models\Payer;
use Piplmodules\Users\Models\UserPreference;
use App\Jobs\SendEmailQueue;
use Mail;
use Piplmodules\Emailtemplates\Models\EmailTemplateTrans;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $url = 'payers/490/rates';
        $request_type = 'GET';
        $post_data = [];
        $res = GeneralHelper::thunesAPI($url, $request_type, $post_data);

        $current_rate = ($res) ? number_format($res->rates->C2C->USD[0]->wholesale_fx_rate, 2) : 0;
        session(['current_rate' => $current_rate]);

        $user_info = User::where(['id' => $user_id])->first();
        $notifications = null;//auth()->user()->unreadNotifications;
        $user_activity = UserActivityDetails::where(['user_id' => $user_id])->first();
        if (isset($user_activity)) {
            session(['send_amount' => $user_activity->send_amount, 'receive_amount' => $user_activity->receive_amount, 'payment_method' => explode("###", $user_activity->payment_method)[0], 'bank_name' => explode("###", $user_activity->bank_name)[0], 'bank_id' => explode("###", $user_activity->bank_name)[1]]);
        }
        return view('dashboard', compact('user_info', 'notifications', 'user_activity'));
    }

    public function editProfile()
    {
        $user_id = Auth::user()->id;
        $user_data = User::where(['id' => $user_id])->first();
        $user_info = UserInformation::where(['user_id' => $user_id])->first();
        $receiving_countries = ReceivingCountry::where(['status' => 1])->get();

        $active_tab = "";
        $errors = session('errors');
        if ($errors) {
            $fields_tabs = [
                ['first_name', 'last_name'], // Tab 0
                ['address_line_1', 'city', 'state', 'zip_code'], // Tab 1
                ['mobile_number'], // Tab 2
                ['email'], // Tab 3
                ['current_password', 'new_password', 'new_confirm_password'], // Tab 4
                ['send_money_to'], // Tab 5
                ['send_money_from'], // Tab 6
            ];
            foreach ($fields_tabs as $tab => $fields) {
                foreach ($fields as $field) {
                    if ($errors->has($field)) {
                        $active_tab = $tab;
                        break;
                    }
                }
            }
        }
        return view('profile.edit-profile', compact('user_data', 'user_info', 'active_tab', 'receiving_countries'));
    }

    public function submitProfile()
    {

        return view('profile.submit-profile');
    }

    public function changeSendToCountry(Request $request)
    {
        $user_id = Auth::user()->id;
        if(Auth::user()->userRole->role_id == '3'){
            $user = UserInformation::where(['id' => $user_id])->first();
            $user->send_money_to = $request->country_iso_code;
            $user->save();

            $site_title = GlobalValues::get('site_title');
            $site_email = GlobalValues::get('site_email');
            $email_template_key = "changed-country";
            $email_template_view = "emails.changed-country";
            $email_template = EmailTemplateTrans::where("template_key", $email_template_key)->first();
            $arr_keyword_values = array();
            $arr_keyword_values['FIRST_NAME'] = $user->first_name;
            $arr_keyword_values['LAST_NAME'] = $user->last_name;
            $arr_keyword_values['SITE_TITLE'] = $site_title;
            $arr_keyword_values['SITE_URL'] = url('/');
            if ($user->user->email != ""){
                $job = (new SendEmailQueue($email_template_view, $arr_keyword_values, $user->user->email, $email_template->subject));
                dispatch($job);
            }
            return Response::json(['success' => true], 200);
        }else{
            return Response::json(['success' => false,'msg' =>'Unauthorized access'], 200);
        }
    }

    protected function validator(array $data, $user_id)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'dob' => ['required']
        ]);
    }

    protected function phoneValidator(array $data, $user_id)
    {
        return Validator::make($data, [
            'mobile_number' => ['required', 'digits:10', 'numeric', 'unique:users,mobile_number,' . $user_id, 'regex:/^([0-9\s\-\+\(\)]*)$/']
        ]);
    }

    protected function emailValidator(array $data, $user_id)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', 'max:255', 'unique:users,email,' . $user_id]
        ]);
    }


    public function updateProfile(Request $request)
    {
        $user_id = Auth::user()->id;
        $this->validator($request->all(), $user_id)->validate();

        $user = User::where(['id' => $user_id])->first();
        $user->name = $request->first_name . " " . $request->last_name;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->save();

        $userinfo = UserInformation::where(['user_id' => $user_id])->first();
        $userinfo->dob = date("Y-m-d", strtotime($request->dob));
        $userinfo->save();

        request()->session()->flash('alert-success', 'Profile updated successfully');

        return redirect('edit-profile');
    }

    public function updateAddress(Request $request)
    {
        $data = $request->all();
        $validate_response = Validator::make($data, [
            'address_line_1' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'zip_code' => ['required', 'postal_code:MX,GU,HI,CR,SV']
        ]);

        if ($validate_response->fails()) {
            return back()
                ->withErrors($validate_response)
                ->withInput();
        } else {
            $user_id = Auth::user()->id;

            $user = UserInformation::where(['id' => $user_id])->first();
            $user->address_line_1 = $request->address_line_1;
            $user->address_line_2 = $request->address_line_2;
            $user->city = $request->city;
            $user->state = $request->state;
            $user->zip_code = $request->zip_code;
            $user->save();

            request()->session()->flash('alert-success', 'Address updated successfully.');
            return redirect('edit-profile');
        }
    }

    public function updatePhoneNumber(Request $request)
    {
        $user_id = Auth::user()->id;
        $this->phoneValidator($request->all(), $user_id)->validate();
        $user = User::where(['id' => $user_id])->first();
        $user->country_code = $request->mobile_number_phoneCode;
        $user->mobile_number = $request->mobile_number;
        $user->save();

        request()->session()->flash('alert-success', 'Phone number updated successfully.');
        return redirect('edit-profile');
    }

    public function updateUserEmail(Request $request)
    {
        $user_id = Auth::user()->id;
        $this->emailValidator($request->all(), $user_id)->validate();
        $user = User::where(['id' => $user_id])->first();
        $user->email = $request->email;
        $user->save();

        request()->session()->flash('alert-success', 'Email updated successfully.');
        return redirect('edit-profile');
    }


    public function updateSendMoney(Request $request)
    {
        $user_id = Auth::user()->id;
        //$this->validator($request->all(), $user_id)->validate();

        $user = UserInformation::where(['id' => $user_id])->first();
        $user->send_money_to = $request->send_money_to;
        $user->save();

        $site_title = GlobalValues::get('site_title');
        $site_email = GlobalValues::get('site_email');
        $email_template_key = "changed-country";
        $email_template_view = "emails.changed-country";
        $email_template = EmailTemplateTrans::where("template_key", $email_template_key)->first();
        $arr_keyword_values = array();
        $arr_keyword_values['FIRST_NAME'] = $user->first_name;
        $arr_keyword_values['LAST_NAME'] = $user->last_name;
        $arr_keyword_values['SITE_TITLE'] = $site_title;
        $arr_keyword_values['SITE_URL'] = url('/');
        if ($user->user->email != ""){
            $job = (new SendEmailQueue($email_template_view, $arr_keyword_values, $user->user->email, $email_template->subject));
            dispatch($job);
        }

        request()->session()->flash('alert-success', 'Sending country updated successfully.');
        return redirect('edit-profile');
    }

    protected function validatorProfilePicture(array $data)
    {
        return Validator::make($data, [
            'profile_photo_path' => 'required|mimes:jpeg,jpg,png|max:10000'
        ], [
            'profile_photo_path.required' => 'Please upload profile picture.',
            'profile_photo_path.mimes' => 'The profile picture must be a file of type: jpeg, jpg, png.'
        ]);
    }

    public function updateProfilePicture(Request $request)
    {

        $user_id = Auth::user()->id;
        $this->validatorProfilePicture($request->all())->validate();

        $user = User::where(['id' => $user_id])->first();

        $file = $request->profile_photo_path;
        //get file extension
        $extension = $request->file('profile_photo_path')->getClientOriginalExtension();

        //filename to store
        $filenametostore = time() . '.' . $extension;

        $storage_path = public_path('/img/profile-picture/');

        //Upload file
        $uploadpath = $storage_path . $filenametostore;
        $file->move($storage_path, $uploadpath);

        if (file_exists($storage_path . 'thumbnail/' . $user->profile_photo_path)) {
            @unlink($storage_path . $user->profile_photo_path);
            @unlink($storage_path . 'thumbnail/' . $user->profile_photo_path);
        }

        //Resize image here
        $thumbnailpath = $storage_path . 'thumbnail/' . $filenametostore;
        $image_resize = Image::make($uploadpath);
        $image_resize->resize(400, 150, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image_resize->save($thumbnailpath);

        @unlink($storage_path . $filenametostore);

        $user->profile_photo_path = $filenametostore;
        $user->save();

        request()->session()->flash('alert-success', 'Profile picture updated successfully.');

        return redirect('dashboard');
    }

    public function updatePassword(Request $request)
    {
        $user_id = Auth::user()->id;
        $data = $request->all();
        $validate_response = Validator::make($data, [
            'current_password' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'min:8'],
            'new_confirm_password' => ['same:new_password']
        ]);

        if ($validate_response->fails()) {
            return back()
                ->withErrors($validate_response)
                ->withInput();
        } else {
            $user = User::findOrFail($user_id);
            if (Hash::check($request->current_password, $user->password)) {
                $user->fill([
                    'password' => Hash::make($request->new_password)
                ])->save();


                $site_title = GlobalValues::get('site_title');
                $site_email = GlobalValues::get('site_email');
                $email_template_key = "password-changed";
                $email_template_view = "emails.password-changed";
                $email_template = EmailTemplateTrans::where("template_key", $email_template_key)->first();
                $arr_keyword_values = array();
                $arr_keyword_values['FIRST_NAME'] = $user->first_name;
                $arr_keyword_values['LAST_NAME'] = $user->last_name;
                $arr_keyword_values['SITE_TITLE'] = $site_title;
                $arr_keyword_values['SITE_URL'] = url('/');
                if ($user->email != ""){
                    $job = (new SendEmailQueue($email_template_view, $arr_keyword_values, $user->email, $email_template->subject));
                    dispatch($job);
                }

                request()->session()->flash('alert-success', 'Password updated successfully.');
            } else {
                request()->session()->flash('alert-danger', 'Current password do not match.');
            }
        }

        return redirect('edit-profile');
    }


    public function getRecipients()
    {
        $user_id = Auth::user()->id;
        $user_info = UserInformation::where(['user_id' => $user_id])->first();
        $country_detail = ReceivingCountry::where(['country_iso_code' => ($user_info->send_money_to) ? $user_info->send_money_to : 'MEX'])->first();
        $recipients = UserRecipientDetails::where(['user_id' => $user_id, 'country_code' => $country_detail->phone_code])->get();
        //$recipients = UserRecipientDetails::where(['user_id' => $user_id])->get();
        return view('recipients.list', compact('recipients'));
    }

    public function addRecipient()
    {
        $user_id = Auth::user()->id;
        $user_info = UserInformation::where(['user_id' => $user_id])->first();
        $country_detail = ReceivingCountry::where(['country_iso_code' => ($user_info->send_money_to) ? $user_info->send_money_to : 'MEX'])->first();

        $user_recipient_details = [];
        return view('recipients.add', compact('user_recipient_details', 'country_detail'));
    }

    public function saveRecipient(StoreRecipientDetails $request)
    {


        $validated = $request->validated();

        $user_id = Auth::user()->id;

        if ($request->recipient_id !="") {
            $errorMsg = "Recipient edited successfully";
            $user_recipient_details = UserRecipientDetails::where(['id' => $request->recipient_id, 'user_id' => $user_id])->first();
        } else {
            $errorMsg = "Recipient added successfully";
            $user_recipient_details = new UserRecipientDetails();
        }

        $user_recipient_details->user_id = $user_id;
        $user_recipient_details->bank_account_no = $request->bank_account_no;
        $user_recipient_details->first_name = $request->first_name;
        $user_recipient_details->last_name = $request->last_name;
        $user_recipient_details->phone_no = $request->phone_no;
        $user_recipient_details->country_code = $request->phone_no_phoneCode;
        $user_recipient_details->email = $request->email;
        $user_recipient_details->address = $request->address;
        $user_recipient_details->city = $request->city;
        $user_recipient_details->state = $request->state;
        $user_recipient_details->reason_for_sending = $request->reason_for_sending;
        $user_recipient_details->save();

        return redirect()->route('recipients')->with("alert-success", $errorMsg);
    }

    public function editRecipient($recipient_id)
    {
        $user_id = Auth::user()->id;
        $recipient_info = UserRecipientDetails::where(['id' => $recipient_id, 'user_id' => $user_id])->first();
        if (isset($recipient_info)) {
            return view('recipients.add', compact('recipient_info'));
        } else {
            $errorMsg = "Invalid recipient id.";
            return redirect()->route('recipients')->with("alert-danger", $errorMsg);
        }
    }

    public function deleteRecipient(Request $request)
    {
        $user_id = Auth::user()->id;
        $recipient_info = UserRecipientDetails::where(['id' => $request->recipient_id, 'user_id' => $user_id])->first();
        if (isset($recipient_info)) {
            $recipient_info->delete();
            $errorMsg = "Recipient deleted successfully";
            return response()->json(['error' => false, 'msg' => $errorMsg]);
        } else {
            $errorMsg = "Invalid recipient id.";
            return response()->json(['error' => true, 'msg' => $errorMsg]);
        }
    }

    public function markNotification(Request $request)
    {
        auth()->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

        return response()->noContent();
    }

    public function notification()
    {
        $user_id = auth()->user()->id;
        // $notifications = auth()->user()->unreadNotifications;
        $user_preferences = UserPreference::where(['user_id' => $user_id])->first();
        // dd($user_preferences);
        return view('notification', compact('user_preferences'));
    }

    public function updateNotification(Request $request)
    {
        $user_id = auth()->user()->id;

        $errorMsg = "Notification updated successfully.";

        $user_preferences = UserPreference::where(['user_id' => $user_id])->first();
        if (!isset($user_preferences)) {
            $user_preferences = new UserPreference();
        }

        $user_preferences->user_id = $user_id;
        $user_preferences->email_notification = false;
        if (isset($request->email_notification) && $request->email_notification !== null) {
            $user_preferences->email_notification = true;
        }
        $user_preferences->save();

        return redirect()->route('notifications')->with("alert-success", $errorMsg);
    }

    public function getPayersAPI(Request $request)
    {
        $payers = Payer::where(['payer_service' => $request->payment_method, 'payer_country' => $request->payer_country])->get();
        $html_view = view("ajaxView.payers", compact('payers'))->render();
        return response()->json(['html' => $html_view]);
    }
}
