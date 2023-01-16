<?php

namespace App\PiplModules\admin\Controllers;



use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Session;
use App\User;

use Carbon\Carbon;
use App\Http\Controllers\Controller;

use DB;

use Validator;
use Illuminate\Http\Request;
use Auth;
use Mail;
use Hash;


use App\PiplModules\roles\Models\Role;

use App\PiplModules\roles\Models\Permission;


use Storage;

use App\Models\UserInformation;
use Lang;
use Cache;

use App\UserRole;
use Zend\Http\Header\Date;



/**
 * Class AdminController
 * @package App\PiplModules\admin\Controllers
 */
class AdminController extends Controller {

    private $thumbnail_size = array("width" => 240, "height" => 360);

    /**
     * AdminController constructor.
     */
    public function __construct() {
        \App::setLocale('en');
    }

    /**
     * @description This function is used to validate to parameter
     * @param Request $request
     * @return mixed
     */
    protected function validator(Request $request) {
        //only common files if we have multiple registration
        $this->middleware('auth', ['except' => array('showLogin')]);
        return Validator::make($request, [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'gender' => 'required',
        ]);
    }

    /**
     * @description This function is used to used for logout.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout() {
        $successMsg = "You have logged out successfully!";
        Auth::logout();
        return redirect("admin/login")->with("register-success", $successMsg);
    }

    /**
     * @description This function is used to show to login form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLogin() {
        dd(1);
        /*Session::put('support_chat_access', '0');
        dd(111);
        return view('admin::login');*/
    }

    /**
     * @description This function is used to login support chat view
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function showLoginChat(Request $request) {
        if ($request->method() == "GET") {
            return view('admin::login_support_chat');
        }
    }

    /**
     * @description This function is used to show support-chat view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function showSupportChat() {
        if (Auth::user()) {
            if (Session::get('support_chat_access') != '1') {
                return redirect("admin/login-chat");
            } else {
                return view('admin::support-chat');
            }
        } else {
            return redirect("admin/login-chat");
        }
    }

    /**
     * @description This function is used to give the date difference.
     * @param $date1
     * @param $date2
     * @return float
     */
    function dateDiff($date1, $date2) {
        $date1_ts = strtotime($date1);
        $date2_ts = strtotime($date2);
        $diff = $date2_ts - $date1_ts;
        return round($diff / 86400);
    }

    /**
     * @description This function is used to give the information that show on dashboard
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function showDashboard(Request $request) {
        if(Auth::user()){
            return view("admin::dashboard");
        } else {
            return redirect("admin/login");
        }
    }

    /**
     * @description This function is used to show the admin profile details
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|View
     */
    public function adminProfile() {
        if (Auth::user()) {
            $arr_user_data = Auth::user();
            $exist_zone = Zone::where('status', 0)->get();
            if($arr_user_data->userAddress->count() > 0)
            {
                $user_state = $arr_user_data->userAddress[0]->user_state;
                $cities = City::translatedIn(\App::getLocale())->where('state_id',$user_state)->get()->toArray();
            }
            else
            {
                $cities = City::translatedIn(\App::getLocale())->get()->toArray();
            }
            $dashboard_Detail = DashboardDetail::where('user_id', $arr_user_data->id)->first();
            return view('admin::profile', array("user_info" => $arr_user_data, "all_zone" => $exist_zone, "dashboard_Detail" => $dashboard_Detail,'cities'=>$cities));
        } else {
            $errorMsg = "Error! Something is wrong going on.";
            Auth::logout();
            return redirect("admin/login")->with("issue-profile", $errorMsg);
        }
    }

    /**
     * @description This function is used to update the admin profile details
     * @param Request $data
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $data) {
        $data_values = $data->all();
        $data['user_mobile'] = substr($data['user_mobile'], 0, 1) == '0' ? ltrim($data['user_mobile'], "0") : $data['user_mobile'];
        $data['user_mobile'] = str_replace(' ', '', $data['user_mobile']);
        $data['user_mobile'] = str_replace(' ', '', $data['user_mobile']);
        $usr_mob_len = $data['mobile_code'] == '+91' ? 10 : 10;

        if (Auth::user()) {
            $arr_user_data = Auth::user();
            $validate_response = Validator::make($data_values, array(
                        'first_name' => 'required',
                        'last_name' => 'required',
                        'gender' => 'required',
                        'default_time_period' => 'required',
                        'city' => 'required',
                        'user_mobile' => 'required|digits:' . $usr_mob_len . '|numeric',
            ));

            if ($validate_response->fails()) {
                return redirect('admin/profile')
                                ->withErrors($validate_response)
                                ->withInput();
            } else {
                /*if (isset($data["profile_picture"])) {
                    $arr_user_data->userInformation->profile_picture = $data["profile_picture"];
                }*/
                if (isset($data["gender"])) {
                    $arr_user_data->userInformation->gender = $data["gender"];
                }
                if (isset($data["user_status"])) {
                    $arr_user_data->userInformation->user_status = $data["user_status"];
                }

                if (isset($data["first_name"])) {
                    $arr_user_data->userInformation->first_name = preg_replace('/\s/', '', $data["first_name"]);
                }
                if (isset($data["last_name"])) {
                    $arr_user_data->userInformation->last_name = preg_replace('/\s/', '', $data["last_name"]);
                }
                if (isset($data["about_me"])) {
                    $arr_user_data->userInformation->about_me = $data["about_me"];
                }

                if (isset($data["user_mobile"])) {
                    $arr_user_data->username = $data["user_mobile"];
                    $old_number = $arr_user_data->userInformation->user_mobile;
                    $arr_user_data->userInformation->user_mobile = $data["user_mobile"];
                    $arr_user_data->userInformation->alternate_number = $old_number;
                }
                if(isset($data["city"]))
                {
                    if($arr_user_data->userAddress->count() > 0)
                    {
                        foreach($arr_user_data->userAddress as $address)
                        {
                            $address->user_city = $data["city"];
                            $address->save();
                        }
                    }
                }

                /*if (isset($data["user_mobile"])) {
                    $arr_user_data->userInformation->user_mobile = $data["user_mobile"];
                }*/

                if ($data->hasFile('profile_image')) {

                    $uploaded_file = $data->file('profile_image');
                    $extension = $uploaded_file->getClientOriginalExtension();
                    $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
                    if(Auth::user()->userInformation->user_type == '1')
                    {
                        Storage::put('public/user-image/'.$new_file_name,file_get_contents($uploaded_file->getRealPath()));
                    }
                    else
                    {
                        Storage::put('public/agent-image/'.$new_file_name,file_get_contents($uploaded_file->getRealPath()));
                    }

                    /*$path = realpath(dirname(__FILE__) . '/../../../../');
                    $old_file = $path . '/storage_app/app/public/user-images/' . $new_file_name;
                    $new_file = $path . '/storage_app/app/public/user-images/' . $new_file_name;
                    $dir = base_path() . '/' . 'storage_app/app/public/user-images';
                    file_put_contents($dir . '/' . $new_file_name, file_get_contents($data->file('profile_image')->getRealPath()));
                    $command = "convert " . $old_file . " -resize 300x200^ " . $new_file;*/
                    $arr_user_data->userInformation->profile_picture = $new_file_name;
                }

                $arr_user_data->userInformation->save();
                $arr_user_data->save();
                $dashboard_Detail = DashboardDetail::where('user_id', $arr_user_data->id)->first();
                if (isset($dashboard_Detail) && count($dashboard_Detail) > 0) {
                    if (isset($data["default_time_period"])) {
                        $dashboard_Detail->default_time_period = $data["default_time_period"];
                    }
                    if (isset($data["city"])) {
                        $dashboard_Detail->region = $data["city"];
                    }
                    $dashboard_Detail->save();
                } else {
                    $create_dashboard_detail = new DashboardDetail();
                    $create_dashboard_detail->default_time_period = $data["default_time_period"];
                    $create_dashboard_detail->region = $data["city"];
                    $create_dashboard_detail->user_id = $arr_user_data->id;
                    $create_dashboard_detail->save();
                }
                $succes_msg = "Your profile has been updated successfully!";
                if(Auth::user()->userInformation->user_type == '1')
                {
                    return redirect("admin/profile")->with("profile-updated", $succes_msg);
                }
                else
                {
                    return redirect("agent/profile")->with("profile-updated", $succes_msg);
                }

            }
        } else {
            $errorMsg = "Error! Something is wrong going on.";
            Auth::logout();
            return redirect("admin/login")->with("issue-profile", $errorMsg);
        }
    }

    

    /**
     * @description This function is used to change the email address and sending email with verification link
     * @param Request $data
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    protected function updateEmailInfo(Request $data) {
        $data_values = $data->all();
        if (Auth::user()) {
            $arr_user_data = Auth::user();
            $validate_response = Validator::make($data_values, array(
                        'email' => 'required|email|max:500|unique:users',
                        'confirm_email' => 'required|email|same:email',
            ));

            if ($validate_response->fails()) {
                return redirect('admin/profile')
                                ->withErrors($validate_response)
                                ->withInput();
            } else {
                //dd($data->all());
                //updating user email
                $arr_user_data->email = $data->email;
                $arr_user_data->save();

                //updating user status to inactive
                $arr_user_data->userInformation->user_status = '1';
                $arr_user_data->userInformation->save();
                //sending email with verification link

                /*$arr_keyword_values = array();
                $activation_code = $this->generateReferenceNumber();
                $site_email = GlobalValues::get('site-email');
                $site_title = GlobalValues::get('site-title');
                //Assign values to all macros
                $arr_keyword_values['FIRST_NAME'] = $arr_user_data->userInformation->first_name;
                $arr_keyword_values['LAST_NAME'] = $arr_user_data->userInformation->last_name;
                $arr_keyword_values['VERIFICATION_LINK'] = url('admin/verify-user-email/' . $activation_code);
                $arr_keyword_values['SITE_TITLE'] = $site_title;
                $arr_keyword_values['SITE_EMAIL'] = $site_email;
                $site_url = GlobalValues::get('site-url');
                $facebook_url = GlobalValues::get('facebook-link');
                $instagram_url = GlobalValues::get('instagram-link');
                $youtube_url = GlobalValues::get('youtube-link');
                $twitter_url = GlobalValues::get('twitter-link');
                $arr_keyword_values['SITE_URL'] = $site_url;
                $arr_keyword_values['FACEBOOK_URL'] = $facebook_url;
                $arr_keyword_values['INSTAGRAM_URL'] = $instagram_url;
                $arr_keyword_values['YOUTUBE_URL'] = $youtube_url;
                $arr_keyword_values['TWITTER_URL'] = $twitter_url;
                // updating activation code
                $arr_user_data->userInformation->activation_code = $activation_code;
                $arr_user_data->userInformation->save();
                if(isset($arr_user_data) && $arr_user_data->email!=""){
                    @Mail::send('emailtemplate::user-email-change-en', $arr_keyword_values, function ($message) use ($arr_user_data, $site_email, $site_title) {
                        $message->to($arr_user_data->email)->subject("Email Changed Successfully!")->from($site_email, $site_title);
                    });
                }
                */

                $successMsg = "Congratulations! your email has been updated successfully.";
                if(Auth::user()->userInformation->user_type == '1')
                {
                    $type = 'admin';
                }
                else
                {
                    $type = 'agent';
                }
                Auth::logout();
                return redirect("$type/login")->with("register-success", $successMsg);
            }
        } else {
            $errorMsg = "Error! Something is wrong going on.";
            Auth::logout();
            return redirect("admin/login")->with("issue-profile", $errorMsg);
        }
    }

    /**
     * @description This function is used to change the email address and sending email with verification link
     * @param Request $data
     * @param $user_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    protected function updateAdminUserEmailInfo(Request $data, $user_id) {
        $data_values = $data->all();
        if (Auth::user()) {
            $arr_user_data = User::find($user_id);
            $validate_response = Validator::make($data_values, array(
                        'email' => 'required|email|max:500|unique:users,email,' . $user_id,
                        'confirm_email' => 'required|email|same:email',
            ));
            if ($validate_response->fails()) {
                return redirect('admin/update-admin-user/' . $user_id)
                                ->withErrors($validate_response)
                                ->withInput();
            } else {
                //updating user email
                $arr_user_data->email = $data->email;
                $arr_user_data->save();

                //updating user status to inactive
                $arr_user_data->userInformation->user_status = 0;
                $arr_user_data->userInformation->save();
                //sending email with verification link

                $arr_keyword_values = array();
                $activation_code = $this->generateReferenceNumber();
                $site_email = GlobalValues::get('site-email');
                $site_title = GlobalValues::get('site-title');
                //Assign values to all macros
                $arr_keyword_values['FIRST_NAME'] = $arr_user_data->userInformation->first_name;
                $arr_keyword_values['LAST_NAME'] = $arr_user_data->userInformation->last_name;
                $arr_keyword_values['VERIFICATION_LINK'] = url('admin/verify-user-email/' . $activation_code);
                $arr_keyword_values['SITE_TITLE'] = $site_title;
                $arr_keyword_values['SITE_EMAIL'] = $site_email;
                $site_url = GlobalValues::get('site-url');
                $facebook_url = GlobalValues::get('facebook-link');
                $instagram_url = GlobalValues::get('instagram-link');
                $youtube_url = GlobalValues::get('youtube-link');
                $twitter_url = GlobalValues::get('twitter-link');
                $arr_keyword_values['SITE_URL'] = $site_url;
                $arr_keyword_values['FACEBOOK_URL'] = $facebook_url;
                $arr_keyword_values['INSTAGRAM_URL'] = $instagram_url;
                $arr_keyword_values['YOUTUBE_URL'] = $youtube_url;
                $arr_keyword_values['TWITTER_URL'] = $twitter_url;
                // updating activation code
                $arr_user_data->userInformation->activation_code = $activation_code;
                $arr_user_data->userInformation->save();
                if($arr_user_data->email != ""){
                    // oommented due to smpt detail delay
                    /*@Mail::send('emailtemplate::user-email-change-en', $arr_keyword_values, function ($message) use ($arr_user_data, $site_email, $site_title) {
                        $message->to($arr_user_data->email)->subject("Email Changed Successfully!")->from($site_email, $site_title);
                    });*/
                }
                $succes_msg = "Admin user email has been updated successfully!";
                return redirect("admin/update-admin-user/" . $user_id)->with("email-updated", $succes_msg);
            }
        } else {
            $errorMsg = "Error! Something is wrong going on.";
            Auth::logout();
            return redirect("admin/login")->with("issue-profile", $errorMsg);
        }
    }

    /**
     * @description This function is used to update the password.
     * @param Request $data
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    protected function updatePasswordInfo(Request $data) {
        $current_password = $data->new_password;
        $data_values = $data->all();
        if (Auth::user()) {
            $arr_user_data = Auth::user();
            $validate_response = Validator::make($data_values, array(
                        'new_password' => 'required|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9@$!%*?&]*$/',
                        'confirm_password' => 'required|same:new_password',
            ));

            if ($validate_response->fails()) {
                return redirect('admin/profile')
                                ->withErrors($validate_response)
                                ->withInput();
            } else {
                //updating user Password
                $arr_user_data->password = $data->new_password;
                $arr_user_data->save();
                $succes_msg = "Congratulations! your password has been updated successfully!";
                if(Auth::user()->userInformation->user_type == '1') {
                    return redirect("admin/profile")->with("password-update-success", $succes_msg);
                }
                else
                {
                    return redirect("agent/profile")->with("password-update-success", $succes_msg);
                }

            }
        } else {
            $errorMsg = "Error! Something wrong is going on.";
            Auth::logout();
            return redirect("login")->with("issue-profile", $errorMsg);
        }
    }

    

    /**
     * @description This function is used to update the password.
     * @param Request $data
     * @param $user_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    protected function updateAdminUserPasswordInfo(Request $data, $user_id) {
        $current_password = $data->current_password;
        $data_values = $data->all();
        if (Auth::user()) {
            $arr_user_data = User::find($user_id);

            $validate_response = Validator::make($data_values, array(
                        'new_password' => 'required|min:7|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9@$!%*?&]*$/',
                        'confirm_password' => 'required|same:new_password',
                            ), array("new_password.regex" => 'Please enter a valid password(allowed special charactors (@$!%*?&))'));

            if ($validate_response->fails()) {
                return redirect("admin/update-admin-user/" . $user_id)
                                ->withErrors($validate_response)
                                ->withInput();
            } else {
                //updating user Password
                $arr_user_data->password = $data->new_password;
                $arr_user_data->save();
                $succes_msg = "Admin user password has been updated successfully!";
                return redirect("admin/update-admin-user/" . $user_id)->with("profile-updated", $succes_msg);
            }
        } else {
            $errorMsg = "Error! Something wrong is going on.";
            Auth::logout();
            return redirect("login")->with("issue-profile", $errorMsg);
        }
    }

    

    /**
     * @description This function is used to verify email address.
     * @param $activation_code
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function verifyUserEmail($activation_code) {
        $user_informations = UserInformation::where('activation_code', $activation_code)->get()->first();
        if ($user_informations) {
            if ($user_informations->user_status === '0') {
                //updating the user status to active
                $user_informations->user_status = '1';
                $user_informations->activation_code = '';
                $user_informations->save();
                $successMsg = "Congratulations! your account has been successfully verified. Please login to continue";
                Auth::logout();
                return redirect("admin/login")->with("register-success", $successMsg);
            } else {
                $user_informations->activation_code = '';
                $user_informations->save();
                $errorMsg = "Error! this link has been expired";
                Auth::logout();
                return redirect("admin/login")->with("login-error", $errorMsg);
            }
        } else {
            $errorMsg = "Error! this link has been expired";
            Auth::logout();
            return redirect("admin/login")->with("login-error", $errorMsg);
        }
    }

    /**
     * @description This function is used to show all registered user on listing
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function listRegisteredUsers() {
        $all_countries = Country::translatedIn(\App::getLocale())->get();
        return view("admin::list-users", array("all_countries" => $all_countries));
    }

    /**
     * @description This function is used to show payment received details
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function userPaymentRecived() {
        $userAllPayments = UserPaymentReceivedDetail::all();
        return view("admin::user-payments", array("all_payments" => $userAllPayments));
    }

    

    /**
     * @description This function is used to return the passenger registered user details
     * @param Request $request
     * @return mixed
     */
    public function listRegisteredUsersData(Request $request) {
        $country_name = $request->country_name;
        $filter_by_week = $request->week_filter;
        $order_filter_by = $request->order_filter_by;
        $order_country_id = $request->order_country;
        $order_drivert_date = $request->drivert_date;
        $order_end_date = $request->end_date;
        $registered_users = UserInformation::select('user_informations.user_id as id', 'user_informations.user_type', 'user_informations.first_name', 'user_informations.last_name', 'users.email', 'user_informations.mobile_code', 'user_informations.user_mobile', 'user_informations.user_status','user_informations.added_by', 'user_informations.platform', 'user_informations.created_at');
        $registered_users->leftJoin('users', function ($join) {
            $join->on('user_informations.user_id', '=', 'users.id');
        });
        if(Auth::user()->userInformation->user_type == '3')
        {
            $registered_users->where(['user_informations.user_type' => '5'])->where(['user_informations.added_by' => Auth::user()->id]);
        }
        else
        {
            $registered_users->where(['user_informations.user_type' => '5']);
        }

        if ($order_country_id != "") {
            $registered_users->where(['user_informations.mobile_code' => $order_country_id]);
        }
        if ($order_drivert_date != "" && $order_end_date != "") {
            $registered_users->whereBetween(['user_informations.created_at' => [$order_drivert_date, $order_end_date]]);
        }

        if ($order_filter_by != "") {
            $registered_users->where(['user_informations.user_status' => $order_filter_by]);
        }

        return Datatables::of($registered_users)
                        ->addColumn('full_name', function ($regsiter_user) {
                            return $regsiter_user->first_name . ' ' . $regsiter_user->last_name;
                        })
                        ->addColumn('email', function ($regsiter_user) {
                            return $regsiter_user->email;
                        })
                        ->addColumn('mobile_number', function ($regsiter_user) {
                            return "+" . str_replace("+", "", $regsiter_user->mobile_code) . " " . $regsiter_user->user_mobile;
                        })
                        ->addColumn('no_of_ride', function ($regsiter_user) {
                            $no_of_rides = 0;
                            $count_of_rides = Order::where('customer_id', $regsiter_user->id)->get();
                            if (isset($count_of_rides) && count($count_of_rides) > 0) {
                                $no_of_rides = count($count_of_rides);
                            }
                            return $no_of_rides;
                        })
                        ->addColumn('avg_rating', function ($regsiter_user) {
                            $userRating = UserRatingInformation::where('to_id', $regsiter_user->id)->where('status', '1')->avg('rating');
                            return isset($userRating) ? round($userRating,1) : '0';
                        })
                        ->addColumn('location', function ($regsiter_user) {
                            $location = '';
                            if ($regsiter_user->mobile_code == "91") {
                                $location = "India";
                            }
                            if ($regsiter_user->mobile_code == "965") {
                                $location = "Kuwait";
                            }
                            return $location;
                        })
                        ->addColumn('status', function ($regsiter_user) {
                            $html = '';
                            if ($regsiter_user->user_status == 0) {
                                $html = '<div  id="active_div' . $regsiter_user->id . '"    style="display:none;"  >
                                                <a class="btn btn-active" title="Click to Change changeStarUserStatus" onClick="javascript:changeStatus(' . $regsiter_user->id . ', 2);" href="javascript:void(0);" id="status_' . $regsiter_user->id . '">Active</a> </div>';
                                $html = $html . '<div id="inactive_div' . $regsiter_user->id . '"  style="display:inline-block" >
                                                <a class="btn btn-inactive" title="Click to Change Status" onClick="javascript:changeStatus(' . $regsiter_user->id . ', 1);" href="javascript:void(0);" id="status_' . $regsiter_user->id . '">Inactive </a> </div>';
                                $html = $html . '<div id="blocked_div' . $regsiter_user->id . '" style="display:none;"  >
                                                <a class="btn btn-inactive" title="Click to Change Status" onClick="javascript:changeStatus(' . $regsiter_user->id . ', 1);" href="javascript:void(0);" id="status_' . $regsiter_user->id . '">Blocked </a> </div>';
                            } else if ($regsiter_user->user_status == 2) {
                                $html = '<div  id="active_div' . $regsiter_user->id . '"  style="display:none;" >
                                                <a class="btn btn-active" title="Click to Change Status" onClick="javascript:changeStatus(' . $regsiter_user->id . ', 2);" href="javascript:void(0);" id="status_' . $regsiter_user->id . '">Active</a> </div>';
                                $html = $html . '<div id="blocked_div' . $regsiter_user->id . '"    style="display:inline-block" >
                                                <a class="btn btn-inactive" title="Click to Change Status" onClick="javascript:changeStatus(' . $regsiter_user->id . ', 1);" href="javascript:void(0);" id="status_' . $regsiter_user->id . '">Blocked</a> </div>';
                            } else if ($regsiter_user->user_status == 3) {
                                $html = '<div  id="active_div' . $regsiter_user->id . '"  style="display:none;" >
                                                <a class="btn btn-active title="Click to Change Status" onClick="javascript:changeStatus(' . $regsiter_user->id . ', 2);" href="javascript:void(0);" id="status_' . $regsiter_user->id . '">Active</a> </div>';
                                $html = $html . '<div id="blocked_div' . $regsiter_user->id . '"    style="display:none" >
                                                <a class="btn btn-inactive" title="Click to Change Status" onClick="javascript:changeStatus(' . $regsiter_user->id . ', 1);" href="javascript:void(0);" id="status_' . $regsiter_user->id . '">Blocked</a> </div>';
                                $html = $html . '<div id="suspended_div' . $regsiter_user->id . '"    style="display:inline-block" >
                                                <a class="btn btn-suspended" title="Click to Change Status" onClick="javascript:changeStatus(' . $regsiter_user->id . ', 1);" href="javascript:void(0);" id="status_' . $regsiter_user->id . '">Suspended</a> </div>';
                            } else {
                                $html = '<div  id="active_div' . $regsiter_user->id . '"   style="display:inline-block" >
                                                <a class="btn btn-active" title="Click to Change Status" onClick="javascript:changeStatus(' . $regsiter_user->id . ', 2);" href="javascript:void(0);" id="status_' . $regsiter_user->id . '">Active</a> </div>';
                                $html = $html . '<div id="blocked_div' . $regsiter_user->id . '"  style="display:none;"  >
                                                <a class="btn btn-inactive" title="Click to Change Status" onClick="javascript:changeStatus(' . $regsiter_user->id . ', 1);" href="javascript:void(0);" id="status_' . $regsiter_user->id . '">Blocked</a> </div>';
                            }
                            return $html;
                        })
                        ->addColumn('device', function ($regsiter_user) {

                            if ($regsiter_user->platform == '0') {
                                $device = "Android";
                            } else if ($regsiter_user->platform == '1') {
                                $device = "IOS";
                            } else {
                                $device = "Web";
                            }
                            return $device;
                        })
                        ->addColumn('created_at', function ($regsiter_user) {
                            return Carbon::createFromTimeStamp(strtotime($regsiter_user->created_at))->format('m-d-Y H:i A');
                        })
                        ->make(true);
    }

    /**
     * @description This function is used to delete the passenger user
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteRegisteredUser($user_id) {

        $user = User::find($user_id);
        if ($user) {
            $check_customer_active_orders = Order::where('customer_id', $user_id)->get();
            if (count($check_customer_active_orders) == 0) {
                $user->delete();
                if(Auth::user()->userInformation->user_type == '1')
                {
                    return redirect('admin/manage-users')->with('delete-user-status', 'Customer has been deleted successfully!');
                }
                else
                {
                    return redirect('agent/manage-users')->with('delete-user-status', 'Customer has been deleted successfully!');
                }
            } else {
                return redirect('admin/manage-users')->with('already_have_ride', 'This passenger have already performed ride, so you can not delete this passenger');
            }
        } else {
            return redirect("admin/manage-users");
        }
    }

    

    /**
     * @description This function is used to delete selected registered user
     * @param type $user_id
     */
    public function deleteSelectedRegisteredUser($user_id) {
        $user = User::find($user_id);

        if ($user) {
            $user->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

    /**
     * @description This function is used to show the particular passenger details on view
     * @param Request $request
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function viewRegisteredUser(Request $request,$user_type, $user_id)
    {
        $user_info = User::find($user_id);
        $last_order_details = Order::where('customer_id', $user_id)->latest()->first();

        $sql = "SELECT final_amout, SUM(COALESCE(CASE WHEN transaction_type = '1' THEN final_amout END,0)) total_debits , SUM(COALESCE(CASE WHEN transaction_type = '0' THEN final_amout END,0)) total_credits , (SUM(COALESCE(CASE WHEN transaction_type = '0' THEN final_amout END,0)) - SUM(COALESCE(CASE WHEN transaction_type = '1' THEN final_amout END,0))) balance FROM " . DB::getTablePrefix() . "user_wallet_details WHERE user_id=" . $user_id . " AND payment_receipt_flag='0' GROUP BY user_id HAVING balance <> 0";
        $user_wallet_data = DB::select(DB::raw($sql));
        $all_wallet_data = array();
        if (isset($user_wallet_data) && count($user_wallet_data)) {
            $all_wallet_data = (array) $user_wallet_data[0];
        }
        $currencyCode = $this->getUserCurrencyCode($user_id);
        $all_rating_data = UserRatingInformation::where('to_id', $user_id)->where('status', '1')->get();
        $avg_rating = $this->getUserAvgRating($user_id);
        $all_SupportTicket = SupportTicket::where('added_by', $user_id)->orderBy('id', 'DESC')->first();
        $locale = "en";
        $services = Service::translatedIn($locale)->get();
        $zones = Zone::translatedIn($locale)->get();
        $cities = City::translatedIn($locale)->get();
        /*$call_data = DB::table('twillio_call_logs')
                ->select('order_id', 'duration', DB::raw("(SELECT CONCAT(" . DB::getTablePrefix() . "user_informations.first_name,' ', " . DB::getTablePrefix() . "user_informations.last_name) FROM " . DB::getTablePrefix() . "user_informations WHERE " . DB::getTablePrefix() . "twillio_call_logs.from_id=" . DB::getTablePrefix() . "user_informations.user_id) as from_name"), DB::raw("(SELECT CONCAT(" . DB::getTablePrefix() . "user_informations.first_name,' ', " . DB::getTablePrefix() . "user_informations.last_name) FROM " . DB::getTablePrefix() . "user_informations WHERE " . DB::getTablePrefix() . "twillio_call_logs.to_id=" . DB::getTablePrefix() . "user_informations.user_id) as to_name"))
                ->where('from_id', $user_id)
                ->orWhere('to_id', $user_id)
                ->orderBy('id', 'DESC')
                ->get();*/
        //$total_amount_for_ride = Order::where(['customer_id' => $user_id, 'status' => '2'])->sum('total_amount');
        $total_amount_for_ride = Order::where(['customer_id' => $user_id])->sum('total_amount');
        $account_suspeded_list = UserSuspendedReason::where('user_id', $user_id)->orderBy('id', 'desc')->get();
        return view("admin::view-registered-user", compact('zones', 'services', 'user_info', 'last_order_details', 'all_wallet_data', 'all_rating_data', 'user_id', 'all_SupportTicket', 'avg_rating', 'currencyCode', 'call_data', 'account_suspeded_list', 'total_amount_for_ride','cities'));
    }



    

    /**
     * @description This function is used to update the passenger profile
     * @param Request $request
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function updateRegisteredUser(Request $request,$user_type, $user_id) {
        $arr_user_data = User::find($user_id);
        $arr_user_info = UserInformation::where('user_id',$user_id)->first();

        if ($arr_user_data) {
            if ($request->method() == "GET") {
                $all_countries = Country::translatedIn(\App::getLocale())->get();
                $states = "";
                $cities = "";
                $user_country = 0;
                $user_state = 0;
                $user_state = 0;
                $user_city = 0;
                $user_address = "";
                if (isset($arr_user_data->userAddress)) {
                    foreach ($arr_user_data->userAddress as $address) {
                        $user_country = $address->user_country;
                        $user_state = $address->user_state;
                        $user_city = $address->user_city;
                        $user_address = $address->address;
                    }
                }
                $states = State::where('country_id', $user_country)->translatedIn(\App::getLocale())->get();
                $cities = City::where('state_id', $user_state)->where('country_id', $user_country)->translatedIn(\App::getLocale())->get();

                $all_roles = Role::where('level', "<=", 1)->where('slug', '<>', 'superadmin')->get();
                return view("admin::edit-registered-user", array("countries" => $all_countries, "user_state" => $user_state, "user_country" => $user_country, "user_city" => $user_city, "cities" => $cities, "states" => $states, 'user_info' => $arr_user_data, 'roles' => $all_roles));
            } elseif ($request->method() == "POST") {
                $data = $request->all();
                $data['user_mobile'] = substr($data['user_mobile'], 0, 1) == '0' ? ltrim($data['user_mobile'], "0") : $data['user_mobile'];
                $data['user_mobile'] = str_replace(' ', '', $data['user_mobile']);
                $mob_num_len = $data['mobile_code'] == '+91' ? 10 : 10;


                $arrUserEmail = null;
                if(isset($data['email']))
                {
                    $arrUserEmail = User::where("email", $data['email'])->where('id', '!=', $user_id)->get();
                    if (isset($arrUserEmail)) {
                        $arrUserEmail = $arrUserEmail->filter(function ($user) {
                            if (isset($user->userInformation)) {
                                return $user->userInformation->user_type == 5;
                            }
                        });
                    }
                }
                if(isset($data['new_password']) && isset($data['new_password_confirmation']))
                {
                    $validate_response = Validator::make($data, array(
                            'new_password' => 'min:7|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9@$!%*?&]*$/',
                            'new_confirm_password' => 'same:new_password',
                        )
                    );
                }
                $arrUserMobile = UserInformation::where("user_mobile", $data['user_mobile'])->where('user_id', '!=', $user_id)->where('user_type', 5)->first();
                if (count($arrUserEmail) > 0) {
                    $validate_response = Validator::make($data, array(
                                'email' => 'email|max:500|unique:users,email,' . $user_id,
                                    )
                    );
                } elseif (count($arrUserMobile) > 0) {
                    $validate_response = Validator::make($data, array(
                                'user_mobile' => 'required|digits:' . $mob_num_len . '|numeric|unique:user_informations,user_mobile,' . $arr_user_data->userInformation->id,
                                    ));
                } else {
                    $validate_response = Validator::make($data, array(
                                'gender' => 'required',
                                'last_name' => 'required',
                                /*'new_password' => 'min:7|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9@$!%*?&]*$/',
                                'new_confirm_password' => 'same:new_password',*/
                                'first_name' => 'required',
                                'user_status' => 'required|numeric'
                                    )
                    );
                }

                if ($validate_response->fails()) {
                    return redirect('admin/update-registered-user/' . $arr_user_data->id)
                                    ->withErrors($validate_response)
                                    ->withInput();
                } else {
                    
                    /** user information goes here *** */
                    /*$demo = $arr_user_data->userInformation;*/
                    if (isset($data["gender"])) {
                        $arr_user_info->gender = $data["gender"];
                    }
                    if (isset($data["user_status"])) {
                        $arr_user_info->user_status = $data["user_status"];
                    }

                    if (isset($data["first_name"])) {
                        $arr_user_info->first_name = preg_replace('/\s/', '', $data["first_name"]);
                    }
                    if (isset($data["last_name"])) {
                        $arr_user_info->last_name = preg_replace('/\s/', '', $data["last_name"]);
                    }
                    if (isset($data["about_me"])) {
                        $arr_user_info->about_me = $data["about_me"];
                    }
                    if (isset($data["date_of_birth"])) {
                        $arr_user_info->user_birth_date = $data["date_of_birth"];
                    }

                    if (isset($data["user_mobile"])) {
                        $arr_user_info->user_mobile = $data["user_mobile"];
                    }
                    if (isset($data["user_mobile"])) {
                        $arr_user_data->username = $data["user_mobile"];
                    }
                    if (isset($data["mobile_code"]) && $data["mobile_code"] != '') {
                        $arr_user_info->mobile_code = str_replace('+', '', $data['mobile_code']);
                    }
                    if (isset($data["new_password"]) && $data["new_password"] != '') {
                        //if ($arr_user_data->userInformation->facebook_id != '' && $arr_user_data->userInformation->twitter_id != '' && $arr_user_data->userInformation->google_id != '') {   
                        $arr_user_data->password = $data["new_password"];
                        //}
                    }
                    if ($request->hasFile('profile_picture')) {
                        if (isset($arr_user_info->profile_picture) && $arr_user_info->profile_picture != '') {
                            $this->removeProfilePictureFromStrorage($arr_user_info->profile_picture);
                        }
                        $dir = base_path() . '/' . 'storage/app/public/user-image';
                        if (!is_dir($dir)) {
                            mkdir($dir, 0777, true);
                        }
                        $extension = $request->file('profile_picture')->getClientOriginalExtension();
                        $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
                        $status = file_put_contents($dir . '/' . $new_file_name, file_get_contents($request->file('profile_picture')->getRealPath()));
                        if ($status) {
                            $arr_user_info->profile_picture = $new_file_name;
                        }
                    }
                    
                    $arr_user_data->save();
                    $arr_user_info->save();
                    /*dd($demo,$arr_user_data->userInformation);
                    $arr_user_data->userInformation->save();*/

                    //adding address
                    if (isset($data["country"])) {
                        $user_address = UserAddress::where('user_id', $user_id)->where('address_type', '1')->first();
                        if (count($user_address) > 0) {
                            $user_address->user_country = $data["country"];
                            $user_address->user_state = $data["state"];
                            $user_address->user_city = $data["city"];
                            $user_address->save();
                        } else {
                            $arr_userAddress["user_country"] = $data["country"];
                            $arr_userAddress["user_state"] = $data["state"];
                            $arr_userAddress["user_city"] = $data["city"];
                            $arr_userAddress["address_type"] = 1;
                            $arr_userAddress["user_id"] = $user_id;
                            UserAddress::create($arr_userAddress);
                        }
                    }

                    if (trim($data['old_email']) != trim($data['email'])) {
                        if ($arr_user_data->userInformation->facebook_id == '' && $arr_user_data->userInformation->twitter_id == '' && $arr_user_data->userInformation->google_id == '') {
                            $email_send_status = $this->sendEmailOnChangeRegisteredUserEmail($data, $arr_user_data->id);
                        } else {
                            $error_msg = "You Can't change the email id because user is logged in by facebook!";
                            return redirect()->back()->with("email-update-fail", $error_msg);
                        }
                    }
                    if (isset($data["new_password"]) && $data["new_password"] != '') {
                        if ($arr_user_data->userInformation->facebook_id == '' && $arr_user_data->userInformation->twitter_id == '' && $arr_user_data->userInformation->google_id == '') {
                            $arr_user_data->password = $data["new_password"];
                            $arr_user_data->save();
                        } else {
                            $error_msg = "You Can't change the password because user is logged in by facebook!";
                            return redirect()->back()->with("password-update-fail", $error_msg);
                        }
                    }
                    $success_msg = "User profile has been updated successfully!";
                    if($user_type == 'admin')
                    {
                        return redirect("admin/view-registered-user/" . $arr_user_data->id)->with("profile-updated", $success_msg);
                    }
                    else
                    {
                        return redirect("agent/view-registered-user/" . $arr_user_data->id)->with("profile-updated", $success_msg);
                    }
                }
            }
        } else {
            return redirect("admin/manage-users");
        }
    }

    /**
     * @description This function is used to send email when changed registered user email
     * @param $data
     * @param $user_id
     */
    protected function sendEmailOnChangeRegisteredUserEmail($data, $user_id) {
        $arr_user_data = User::find($user_id);
        $arr_user_data->email = $data['email'];
        $arr_user_data->save();

        //updating user status to inactive
        //$arr_user_data->userInformation->user_status = 0;
        ///$arr_user_data->userInformation->save();
        //sending email with verification link
        //sending an email to the user on successfull registration.

        $arr_keyword_values = array();
        $activation_code = $this->generateReferenceNumber();
        $site_email = GlobalValues::get('site-email');
        $site_title = GlobalValues::get('site-title');
        //Assign values to all macros
        $arr_keyword_values['FIRST_NAME'] = $arr_user_data->userInformation->first_name;
        $arr_keyword_values['LAST_NAME'] = $arr_user_data->userInformation->last_name;
        $arr_keyword_values['VERIFICATION_LINK'] = url('verify-user-email/' . $activation_code);
        $arr_keyword_values['SITE_TITLE'] = $site_title;
        $arr_keyword_values['SITE_EMAIL'] = $site_email;
        $site_url = GlobalValues::get('site-url');
        $facebook_url = GlobalValues::get('facebook-link');
        $instagram_url = GlobalValues::get('instagram-link');
        $youtube_url = GlobalValues::get('youtube-link');
        $twitter_url = GlobalValues::get('twitter-link');
        $arr_keyword_values['SITE_URL'] = $site_url;
        $arr_keyword_values['FACEBOOK_URL'] = $facebook_url;
        $arr_keyword_values['INSTAGRAM_URL'] = $instagram_url;
        $arr_keyword_values['YOUTUBE_URL'] = $youtube_url;
        $arr_keyword_values['TWITTER_URL'] = $twitter_url;
        // updating activation code
        $arr_user_data->userInformation->activation_code = $activation_code;
        $arr_user_data->userInformation->save();

        if (isset($arr_user_data->email) && $arr_user_data->email != '') {
            // oommented due to smpt detail delay
            /*@Mail::send('emailtemplate::user-email-change-en', $arr_keyword_values, function ($message) use ($arr_user_data, $site_email, $site_title) {

                $message->to($arr_user_data->email)->subject("Email Changed Successfully!")->from($site_email, $site_title);
            });*/
        }
    }

    /**
     * @description This function is used to update user email information
     * @param Request $data
     * @param $user_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    protected function updateRegisteredUserEmailInfo(Request $data, $user_id) {
        $data_values = $data->all();
        if (Auth::user()) {
            $arr_user_data = User::find($user_id);
            $validate_response = Validator::make($data_values, array(
                        'email' => 'required|email|max:500|unique:users,email',
                        'confirm_email' => 'required|email|same:email',
            ));
            if ($validate_response->fails()) {
                return redirect('admin/update-registered-user/' . $user_id)
                                ->withErrors($validate_response)
                                ->withInput();
            } else {
                //updating user email
                $arr_user_data->email = $data->email;
                $arr_user_data->save();

                //updating user status to inactive
                $arr_user_data->userInformation->user_status = 0;
                $arr_user_data->userInformation->save();
                //sending email with verification link
                //sending an email to the user on successfull registration.

                $arr_keyword_values = array();
                $activation_code = $this->generateReferenceNumber();
                $site_email = GlobalValues::get('site-email');
                $site_title = GlobalValues::get('site-title');
                //Assign values to all macros
                $arr_keyword_values['FIRST_NAME'] = $arr_user_data->userInformation->first_name;
                $arr_keyword_values['LAST_NAME'] = $arr_user_data->userInformation->last_name;
                $arr_keyword_values['VERIFICATION_LINK'] = url('verify-user-email/' . $activation_code);
                $arr_keyword_values['SITE_TITLE'] = $site_title;
                $arr_keyword_values['SITE_EMAIL'] = $site_email;
                $site_url = GlobalValues::get('site-url');
                $facebook_url = GlobalValues::get('facebook-link');
                $instagram_url = GlobalValues::get('instagram-link');
                $youtube_url = GlobalValues::get('youtube-link');
                $twitter_url = GlobalValues::get('twitter-link');
                $arr_keyword_values['SITE_URL'] = $site_url;
                $arr_keyword_values['FACEBOOK_URL'] = $facebook_url;
                $arr_keyword_values['INSTAGRAM_URL'] = $instagram_url;
                $arr_keyword_values['YOUTUBE_URL'] = $youtube_url;
                $arr_keyword_values['TWITTER_URL'] = $twitter_url;
                // updating activation code
                $arr_user_data->userInformation->activation_code = $activation_code;
                $arr_user_data->userInformation->save();

                if (isset($arr_user_data->email) && $arr_user_data->email != '') {
                    // oommented due to smpt detail delay
                    /*@Mail::send('emailtemplate::user-email-change-en', $arr_keyword_values, function ($message) use ($arr_user_data, $site_email, $site_title) {

                        $message->to($arr_user_data->email)->subject("Email Changed Successfully!")->from($site_email, $site_title);
                    });*/
                }
                $succes_msg = "User email has been updated successfully!";
                return redirect("admin/update-registered-user/" . $user_id)->with("profile-updated", $succes_msg);
            }
        } else {
            $errorMsg = "Error! Something is wrong going on.";
            Auth::logout();
            return redirect("admin/login")->with("issue-profile", $errorMsg);
        }
    }

    /**
     * @description This function is used to send email when changed the registered user password
     * @param $data
     * @param $user_id
     */
    protected function sendEmailOnChangeRegisteredUserPassword($data, $user_id) {
        $arr_user_data = User::find($user_id);
        $arr_user_data->password = $data['new_password'];
        $arr_user_data->save();
        $arr_keyword_values = array();

        $site_email = GlobalValues::get('site-email');
        $site_title = GlobalValues::get('site-title');
        //Assign values to all macros
        $arr_keyword_values['FIRST_NAME'] = $arr_user_data->userInformation->first_name;
        $arr_keyword_values['LAST_NAME'] = $arr_user_data->userInformation->last_name;
        $arr_keyword_values['PASSWORD'] = $data['new_password'];
        $arr_keyword_values['SITE_TITLE'] = $site_title;
        $site_url = GlobalValues::get('site-url');
        $facebook_url = GlobalValues::get('facebook-link');
        $instagram_url = GlobalValues::get('instagram-link');
        $youtube_url = GlobalValues::get('youtube-link');
        $twitter_url = GlobalValues::get('twitter-link');
        $arr_keyword_values['SITE_URL'] = $site_url;
        $arr_keyword_values['FACEBOOK_URL'] = $facebook_url;
        $arr_keyword_values['INSTAGRAM_URL'] = $instagram_url;
        $arr_keyword_values['YOUTUBE_URL'] = $youtube_url;
        $arr_keyword_values['TWITTER_URL'] = $twitter_url;

        if (isset($arr_user_data->email) && $arr_user_data->email != '') {
            // oommented due to smpt detail delay
            /*@Mail::send('emailtemplate::password-change-en', $arr_keyword_values, function ($message) use ($arr_user_data, $site_email, $site_title) {
                $message->to($arr_user_data->email)->subject("Password changed Successfully!")->from($site_email, $site_title);
            });*/
        }
    }

    /**
     * @description This function is used to update passenger password information
     * @param Request $data
     * @param $user_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    protected function updateRegisteredUserPasswordInfo(Request $data, $user_id) {
        $current_password = $data->current_password;
        $data_values = $data->all();
        if (Auth::user()) {
            $arr_user_data = User::find($user_id);
            $validate_response = Validator::make($data_values, array(
                        'new_password' => 'required|confirmed|min:7|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9@$!%*?&]*$/',
                        'new_password_confirmation' => 'required',
                            ), array("new_password.regex" => 'Please enter a valid password(allowed special charactors (@$!%*?&))'));

            if ($validate_response->fails()) {
                return redirect("admin/update-registered-user/" . $user_id)
                                ->withErrors($validate_response)
                                ->withInput();
            } else {
                //updating user Password
                $arr_user_data->password = $data->new_password;
                $arr_user_data->save();
                $arr_keyword_values = array();

                $site_email = GlobalValues::get('site-email');
                $site_title = GlobalValues::get('site-title');
                //Assign values to all macros
                $arr_keyword_values['FIRST_NAME'] = $arr_user_data->userInformation->first_name;
                $arr_keyword_values['LAST_NAME'] = $arr_user_data->userInformation->last_name;
                $arr_keyword_values['PASSWORD'] = $data->new_password;
                $arr_keyword_values['SITE_TITLE'] = $site_title;
                $site_url = GlobalValues::get('site-url');
                $facebook_url = GlobalValues::get('facebook-link');
                $instagram_url = GlobalValues::get('instagram-link');
                $youtube_url = GlobalValues::get('youtube-link');
                $twitter_url = GlobalValues::get('twitter-link');
                $arr_keyword_values['SITE_URL'] = $site_url;
                $arr_keyword_values['FACEBOOK_URL'] = $facebook_url;
                $arr_keyword_values['INSTAGRAM_URL'] = $instagram_url;
                $arr_keyword_values['YOUTUBE_URL'] = $youtube_url;
                $arr_keyword_values['TWITTER_URL'] = $twitter_url;

                if (isset($arr_user_data->email) && $arr_user_data->email != '') {
                    // oommented due to smpt detail delay
                    /*@Mail::send('emailtemplate::password-change-en', $arr_keyword_values, function ($message) use ($arr_user_data, $site_email, $site_title) {
                        $message->to($arr_user_data->email)->subject("Password changed Successfully!")->from($site_email, $site_title);
                    });*/
                }
                $message = "Your password for Gereeb has been reset to:- " . $data->new_password;
                //sending sms to verified user
                $mobile = $arr_user_data->userInformation->user_mobile;

                $mobile_code = str_replace("+", "", $arr_user_data->userInformation->mobile_code);
                $mobile_number_to_send = "+" . $mobile_code . "" . $mobile;

                $succes_msg = "User password has been updated successfully!";
                return redirect("admin/update-registered-user/" . $user_id)->with("profile-updated", $succes_msg);
            }
        } else {
            $errorMsg = "Error! Something wrong is going on.";
            Auth::logout();
            return redirect("login")->with("issue-profile", $errorMsg);
        }
    }

    

    /**
     * @description This function is used for passenger registration and send email when complete the registration
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|View
     */
    public function createRegisteredUser(Request $request) {
        //dd(\Config::get('mail.password'));
        if ($request->method() == "GET") {
            $all_countries = Country::translatedIn(\App::getLocale())->get();
            return view("admin::create-registered-user", array("countries" => $all_countries));
        } elseif ($request->method() == "POST") {
            $data = $request->all();
            //dd($data);
            $data['user_mobile'] = substr($data['user_mobile'], 0, 1) == '0' ? ltrim($data['user_mobile'], "0") : $data['user_mobile'];
            $data['user_mobile'] = str_replace(' ', '', $data['user_mobile']);
            $data['user_mobile'] = str_replace(' ', '', $data['user_mobile']);
            $usr_mob_len = $data['mobile_code'] == '+91' ? 10 : 8;
            $arrUserEmail = User::where("email", $data['email'])->get();
            if (isset($arrUserEmail) && count($arrUserEmail) > 0) {
                $arrUserEmail = $arrUserEmail->filter(function ($user) {
                    if (isset($user->userInformation) && count($user->userInformation) > 0) {
                        return $user->userInformation->user_type == 5;
                    }
                });
            }
            $arrUserMobile = UserInformation::where("user_mobile", $data['user_mobile'])->where('user_type', 5)->first();
            if (count($arrUserEmail) > 0) {
                $validate_response = Validator::make($data, array(
                            'email' => 'required|email|max:255|unique:users,email',
                                )
                );
            }
            if (count($arrUserMobile) > 0) {
                $validate_response = Validator::make($data, array(
                            'user_mobile' => 'required|digits:' . $usr_mob_len . '|numeric|unique:user_informations,user_mobile,',
                                )
                );
            } else {
                $validate_response = Validator::make($data, array(
                            'password' => 'required|min:7|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9@$!%*?&]*$/',
                            'password_confirmation' => 'required|same:password',
                            'first_name' => 'required',
                            'last_name' => 'required',
                                )
                );
            }
            if ($validate_response->fails()) {
                return redirect()->back()
                                ->withErrors($validate_response)
                                ->withInput();
            } else {
                $created_user = User::create(array(
                            'email' => $data['email'],
                            'password' => ($data['password']),
                            'username' => ($data['user_mobile']),
                ));

                $user_code = $data['user_mobile'] . '-' . $created_user->id;

                // update User Information

                /*
                 * Adjusted user specific columns, which may not passed on front end and adjusted with the default values
                 */
                $data["user_status"] = isset($data["user_status"]) ? $data["user_status"] : "1";  // 0 means not active
                $data["gender"] = isset($data["gender"]) ? $data["gender"] : "3";       // 3 means not specified
                $data["facebook_id"] = isset($data["facebook_id"]) ? $data["facebook_id"] : "";
                $data["twitter_id"] = isset($data["twitter_id"]) ? $data["twitter_id"] : "";
                $data["google_id"] = isset($data["google_id"]) ? $data["google_id"] : "";
                $data["user_birth_date"] = isset($data["user_birth_date"]) ? $data["user_birth_date"] : "";
                $data["first_name"] = isset($data["first_name"]) ? preg_replace('/\s/', '', $data["first_name"]) : "";
                $data["last_name"] = isset($data["last_name"]) ? preg_replace('/\s/', '', $data["last_name"]) : "";
                $data["about_me"] = isset($data["about_me"]) ? $data["about_me"] : "";
                $data["user_mobile"] = isset($data["user_mobile"]) ? $data["user_mobile"] : "";
                $data["mobile_code"] = isset($data["mobile_code"]) ? $data["mobile_code"] : "";
                $new_file_name = '';
                if ($request->file('logo') != '') {
                    $extension = $request->file('logo')->getClientOriginalExtension();
                    $new_file_name = time() . "." . $extension;
                    $old_file = base_path() . '/storage/app/public/user-image/' . $new_file_name;
                    $new_file = base_path() . '/storage/app/public/user-image/' . $new_file_name;
                    Storage::put('public/user-image/' . $new_file_name, file_get_contents($request->file('logo')->getRealPath()));
                    $command = "convert " . $old_file . " -resize 300x200^ " . $new_file;
                    exec($command);
                }
                $referral_code = $this->generateRandomString($data["first_name"]);
                $arr_userinformation = array();
                $arr_userinformation["profile_picture"] = $new_file_name;
                $arr_userinformation["gender"] = $data["gender"];
                $arr_userinformation["activation_code"] = "";             // By default it'll be no activation code
                $arr_userinformation["facebook_id"] = $data["facebook_id"];
                $arr_userinformation["twitter_id"] = $data["twitter_id"];
                $arr_userinformation["google_id"] = $data["google_id"];
                $arr_userinformation["user_birth_date"] = $data["user_birth_date"];
                $arr_userinformation["first_name"] = $data["first_name"];
                $arr_userinformation["last_name"] = $data["last_name"];
                $arr_userinformation["about_me"] = $data["about_me"];
                $arr_userinformation["user_mobile"] = $data["user_mobile"];
                $arr_userinformation["user_status"] = $data["user_status"];
                $arr_userinformation["user_type"] = 5;
                $arr_userinformation["user_id"] = $created_user->id;
                $arr_userinformation["user_code"] = $user_code;
                $arr_userinformation["mobile_code"] = str_replace("+", "", $data["mobile_code"]);
                $arr_userinformation["referral_code"] = $referral_code;
                $arr_userinformation["added_by"] = Auth::user()->id;
                $updated_user_info = UserInformation::create($arr_userinformation);
                /*$created_user->attachRole('2');
                $created_user->save();*/
                $arr_keyword_values = array();
                $email_template_key = "resend-email-activation-link-en";
                $template = EmailTemplate::where("template_key", $email_template_key)->first();
                $activation_code = $this->generateReferenceNumber();
                //Assign values to all macros
                $site_email = 'intranetadmin@katalysttech.com';
                $site_title = GlobalValues::get('site-title');
                $arr_keyword_values['FIRST_NAME'] = $updated_user_info->first_name;
                $arr_keyword_values['LAST_NAME'] = $updated_user_info->last_name;
                $arr_keyword_values['PASSWORD'] = $data["password"];
                $arr_keyword_values['EMAIL'] = $data["email"];
                $arr_keyword_values['RESET_LINK'] = url('verify-user-email/' . $activation_code);
                $arr_keyword_values['SITE_TITLE'] = $site_title;
                $site_url = GlobalValues::get('site-url');
                $facebook_url = GlobalValues::get('facebook-link');
                $instagram_url = GlobalValues::get('instagram-link');
                $youtube_url = GlobalValues::get('youtube-link');
                $twitter_url = GlobalValues::get('twitter-link');
                $arr_keyword_values['SITE_URL'] = $site_url;
                $arr_keyword_values['FACEBOOK_URL'] = $facebook_url;
                $arr_keyword_values['INSTAGRAM_URL'] = $instagram_url;
                $arr_keyword_values['YOUTUBE_URL'] = $youtube_url;
                $arr_keyword_values['TWITTER_URL'] = $twitter_url;

                // updating activation code
                $updated_user_info->activation_code = $activation_code;
                $updated_user_info->save();

                // added user rating
                $driver_user_rating_details = new UserRatingInformation();
                $driver_user_rating_details->from_id = 0;
                $driver_user_rating_details->to_id = $created_user->id;
                $driver_user_rating_details->status = '1';
                $driver_user_rating_details->rating = 5.00;
                $driver_user_rating_details->save();
                //adding address
                if (isset($data["country"])) {
                    $arr_userAddress["user_country"] = $data["country"];
                    $arr_userAddress["user_state"] = $data["state"];
                    $arr_userAddress["user_city"] = $data["city"];
                    $arr_userAddress["address_type"] = 1;
                    $arr_userAddress["user_id"] = $created_user->id;
                    UserAddress::create($arr_userAddress);
                }

                $email_subject = Lang::choice('messages.register_email_subject', "", [], "en");
                $verify_email_subject = Lang::choice('messages.verify_email', "", [], "en");
                $tempate_name = "emailtemplate::passenger-registration-successfull-en";
                $verify_tempate_name = "emailtemplate::resend-email-activation-link-en";
                if (isset($created_user->email) && $created_user->email != '' && $created_user->email != NULL) {
                    // oommented due to smpt detail delay
                    /*@Mail::send($tempate_name, $arr_keyword_values, function ($message) use ($created_user, $email_subject, $site_email, $site_title) {
                                $message->to($created_user->email)->subject($email_subject)->from($site_email, $site_title);
                            });*/

                    // not this
                     /*@Mail::send($tempate_name, $arr_keyword_values, function ($message) use ( $email_subject, $site_email, $site_title) {
                        $message->to('spatel1@katalysttech.com')->subject($email_subject)->from($site_email, $site_title);
                    });*/
                }
                if(Auth::user()->userInformation->user_type == '3')
                {
                    return redirect('agent/manage-users')
                        ->with("update-user-status", "User has been created successfully");
                }
                else
                {
                    return redirect('admin/manage-users')
                        ->with("update-user-status", "User has been created successfully");
                }
            }
        }
    }

    

    

    /**
     * @description This function is used to update the user profile
     * @param Request $request
     * @param $user_id
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|View
     */
    public function editUser(Request $request, $user_id) {
        $user_details = User::find($user_id);
        if ($user_details) {
            if ($request->method() == "GET") {
                if ($user_details->level() <= 1) {
                    // he is admin user, redirect to admin update page
                    return redirect('admin/update-admin-user/' . $user_id);
                }
                return view("admin::edit-user", array('userdata' => $user_details));
            } elseif ($request->method() == "POST") {
                $data = $request->all();

                $validate_response = Validator::make($data, array(
                            'email' => 'required|email|max:255|unique:users,email,' . $user_details->id,
                            'first_name' => 'required',
                            'last_name' => 'required',
                            'user_mobile' => 'required|numeric|unique:users,username,' . $user_details->id,
                ));

                if ($validate_response->fails()) {
                    return redirect('admin/update-user/' . $user_details->id)
                                    ->withErrors($validate_response)
                                    ->withInput();
                } else {
                    $user_details->email = $request->email;
                    $user_details->userInformation->first_name = $request->first_name;
                    $user_details->userInformation->last_name = $request->last_name;
                    $user_details->userInformation->gender = $request->gender;
                    $user_details->userInformation->user_birth_date = $request->user_birth_date;
                    $user_details->userInformation->about_me = $request->about_me;

                    $user_details->userInformation->user_mobile = $request->user_mobile;
                    $user_details->userInformation->user_type = $request->user_type;

                    $user_details->save();
                    $user_details->userInformation->save();

                    return redirect('admin/update-user/' . $user_details->id)
                                    ->with("update-user-status", "User updated successfully");
                }
            }
        } else {
            return redirect("admin/manage-users");
        }
    }

    /**
     * @description This function is used to update the user password
     * @param Request $request
     * @param $user_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function editUserPassword(Request $request, $user_id) {
        $user_details = User::find($user_id);
        if ($user_details) {
            $data = $request->all();
            $validate_response = Validator::make($data, [
                        'new_password' => 'required|min:7|confirmed',
                            ], [
                        'new_password.required' => 'Please enter new password',
                        'new_password.min' => 'Please enter atleast 6 characters',
                        'new_password.confirmed' => 'Confirmation password doesn\'t match',
            ]);

            $return_url = 'admin/update-user/' . $user_details->id;

            if ($user_details->level() <= 1) {
                $return_url = 'admin/update-admin-user/' . $user_details->id;
            }

            if ($validate_response->fails()) {
                return redirect($return_url)
                                ->withErrors($validate_response)
                                ->withInput();
            } else {

                $user_details->password = $request->new_password;
                $user_details->save();

                return redirect($return_url)
                                ->with("update-user-status", "User's password updated successfully");
            }
        } else {
            return redirect()->back();
        }
    }

    /**
     * @description This function is used to update the user status
     * @param Request $request
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editUserStatus(Request $request, $user_id) {
        $user_details = User::find($user_id);

        if ($user_details) {
            $user_details->userInformation->user_status = $request->active_status;
            $user_details->userInformation->save();

            $return_url = 'admin/update-user/' . $user_details->id;

            if ($user_details->level() <= 1) {
                $return_url = 'admin/update-admin-user/' . $user_details->id;
            }

            return redirect($return_url)
                            ->with("update-user-status", "User's status updated successfully");
        } else {
            return redirect()->back();
        }
    }

    /**
     * @description This function is used to delete the admin user
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deletAdminUser($user_id) {
        $user = User::find($user_id);
        if ($user) {
            $user->delete();
            return redirect('admin/admin-users')->with('delete-user-status', 'admin user has been deleted successfully!');
        } else {
            return redirect("admin/admin-users");
        }
    }

    /**
     * @description This function is used to delete the selected admin user
     * @param $user_id
     */
    public function deletSelectedAdminUser($user_id) {
        $user = User::find($user_id);
        if ($user) {
            $user->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

    /**
     * @description This function is used to show the list-roles view
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function listRoles() {
        return view("admin::list-roles");
    }

    /**
     * @description This function is used to return the roles details
     * @return mixed
     */
    public function listRolesData() {
        $role_list = Role::all();
        $role_listing = $role_list->reject(function ($role) {
            return ($role->slug == "superadmin") == true || ($role->slug == "registered.user") == true;
        });
        return Datatables::of($role_listing)
                        ->addColumn("created_at", function ($request) {
                            $date = Carbon::createFromTimeStamp(strtotime($request->created_at))->format('m-d-Y H:i A');
                            return $date;
                        })
                        ->addColumn("updated_at", function ($request) {
                            $date = Carbon::createFromTimeStamp(strtotime($request->updated_at))->format('m-d-Y H:i A');
                            return $date;
                        })
                        ->make(true);
        return Datatables::collection($role_listing)->make(true);
    }

    /**
     * @description This function is used to update role
     * @param Request $request
     * @param $role_id
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|View
     */
    public function updateRole(Request $request, $role_id) {
        $role = Role::find($role_id);
        if ($role) {
            if ($request->method() == "GET") {
                return view('admin::edit-role', ['role' => $role]);
            } else {
                $data = $request->all();
                $validate_response = Validator::make($data, [
                            'slug' => 'required|unique:roles,slug,' . $role->id,
                            'name' => 'required|unique:roles,name,' . $role->id,
                                ], [
                            'slug.required' => 'Please enter slug for role',
                            'slug.unique' => 'The entered slug is already in use. Please try another',
                            'name.required' => 'Please enter name',
                            'name.unique' => 'The entered name is already in use. Please try another'
                                ]
                );

                if ($validate_response->fails()) {
                    return redirect('admin/manage-roles/' . $role->id)
                                    ->withErrors($validate_response)
                                    ->withInput();
                } else {

                    $role->name = $request->name;
                    $role->slug = $request->slug;
                    $role->description = $request->description;
                    $role->level = $request->level;
                    $role->save();

                    return redirect('admin/manage-roles')
                                    ->with("update-role-status", "Role informations has been updated successfully");
                }
            }
        } else {
            return redirect('admin/manage-roles');
        }
    }

    /**
     * @description This function is used to create role
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|View
     */
    public function createRole(Request $request) {
        if ($request->method() == "GET") {
            return view('admin::create-role');
        } else {
            $data = $request->all();
            $validate_response = Validator::make($data, [
                        'slug' => 'required|unique:roles,slug',
                        'name' => 'required|unique:roles,name'
                            ], [
                        'slug.required' => 'Please enter slug for role',
                        'slug.unique' => 'The entered slug is already in use. Please try another',
                        'name.required' => 'Please enter name'
                            ]
            );

            if ($validate_response->fails()) {
                return redirect('admin/roles/create')
                                ->withErrors($validate_response)
                                ->withInput();
            } else {

                $role['name'] = $request->name;
                $role['slug'] = $request->slug;
                $role['description'] = $request->description;
                $role['level'] = 1;

                Role::create($role);

                return redirect('admin/manage-roles/')
                                ->with("role-status", "Role created successfully");
            }
        }
    }

    /**
     * @description This function is used to update role permission
     * @param Request $request
     * @param $role_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function updateRolePermissions(Request $request, $role_id) {
        $role = Role::find($role_id);
        if ($role) {
            if ($request->method() == "GET") {
                $all_permissions = Permission::where(['status' => 1])->orderBy('model')->get();

                $role_permissions = $role->permissions;

                return view("admin::role-permissions", array('role' => $role, 'permissions' => $all_permissions, 'role_permissions' => $role_permissions));
            } else {
                $role->detachAllPermissions();
                $role->save();
                if (count($request->permission) > 0) {
                    foreach ($request->permission as $sel_permission) {
                        $role->attachPermission($sel_permission);
                    }
                    $role->save();
                }
                return redirect('admin/manage-roles')
                                ->with("set-permission-status", "Role permissions has been updated successfully");
            }
        } else {
            return redirect('admin/manage-roles');
        }
    }

    /**
     * @description This function is used to calculate zone wise ride count
     * @param $query
     * @return array
     */
    public function calZoneWiseRideCount($query) {
        $arr = array();
        for ($i = 1; $i <= 12; $i++) {
            $tmp_key = $i;
            if ($i < 10) {
                $tmp_key = '0' . $tmp_key;
            }
            if (array_key_exists($tmp_key, $query)) {
                $arr[] = $query[$tmp_key];
            } else {
                $arr[] = 0;
            }
        }
        return $arr;
    }

    /**
     * @description This function is used to count the user month wise
     * @param $query
     * @return array
     */
    public function calUserMonthWiseCount($query) {
        $arr = array();
        for ($i = 1; $i <= 12; $i++) {
            $tmp_key = $i;
            if ($i < 10) {
                $tmp_key = '0' . $tmp_key;
            }
            if (array_key_exists($tmp_key, $query)) {
                $arr[] = $query[$tmp_key];
            } else {
                $arr[] = 0;
            }
        }
        return $arr;
    }

    /**
     * @description This function is used to return data zonewise and monthwise
     * @param $array
     * @param $key
     * @return array
     */
    public function arrayGroupBy($array, $key) {
        $return = array();
        foreach ($array as $val) {
            $val = (array) $val;
            if ($key == 'month') {
                $return[$val[$key]] = $val['total'];
            } else if ($key == 'zone_name') {
                $return[] = trim(ucfirst(substr($val['zone_name'], 0, 3)));
            } else if ($key == 'total') {
                $return[] = $val['total'];
            } else {
                $return[$val[$key]][] = $val;
            }
        }
        return $return;
    }

    /**
     * @description This function is used to delete the particular role
     * @param $role_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteRole($role_id) {
        $role = Role::find($role_id);
        if ($role) {
            $role->delete();
            return redirect('admin/manage-roles/')
                            ->with("delete-role-status", "Role has been deleted successfully");
        } else {
            return redirect('admin/manage-roles');
        }
    }

    /**
     * @description This function is used to delete the selected role
     * @param $role_id
     */
    public function deleteRoleFromSelectAll($role_id) {
        $role = Role::find($role_id);
        if ($role) {
            $role->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

    /**
     * @description This function is used to show list-global-settings view
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function listGlobalSettings() {
        return view("admin::list-global-settings");
    }

    /**
     * @description This function is used to return the global setting values
     * @return mixed
     */
    public function listGlobalSettingsData() {
        $global_settings = GlobalSetting::where(['status' => '1'])->get();
        return Datatables::of($global_settings)
                        ->addColumn('name', function ($global) {
                            return $value = $global->name;
                        })
                        ->addColumn('value', function ($global) {
                            $value = '';
                            if ($global->slug == 'sitse-logo') {
                                $value = '<img src="' . storage("/storageasset/global-settings/$global->value") . '">';
                            } else {
                                $value = $global->value;
                            }
                            return $value;
                        })
                        ->addColumn("updated_at", function ($global) {
                            $date = Carbon::createFromTimeStamp(strtotime($global->updated_at))->format('m-d-Y H:i A');
                            return $date;
                        })
                        ->make(true);
    }

    /**
     * @description This function is used to update the global setting values
     * @param Request $request
     * @param $setting_id
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|View
     */
    public function updateGlobalSetting(Request $request, $setting_id) {
        $global_setting = GlobalSetting::find($setting_id);
        if ($global_setting) {
            if ($request->method() == "GET") {
                return view("admin::edit-global-settings", array('setting' => $global_setting));
            } else {
                $data = $request->all();

                $validate_response = Validator::make($data, array(
                            'value' => $global_setting->validate,
                                )
                );
                if ($validate_response->fails()) {
                    return redirect('/admin/update-global-setting/' . $global_setting->id)->withErrors($validate_response)->withInput();
                } else {
                    if (in_array("image", explode("|", $global_setting->validate))) {
                        $extension = $request->file('value')->getClientOriginalExtension();

                        $new_file_name = time() . "." . $extension;
                        Storage::put('public/global-settings/' . $new_file_name, file_get_contents($request->file('value')->getRealPath()));

                        $global_setting->value = $new_file_name;
                    } else {
                        $global_setting->value = $request->value;
                    }
                    $global_setting->updated_at = date('Y-m-d H:i:s');
                    $global_setting->save();
                    Cache::forget($global_setting->slug);
                    return redirect('/admin/global-settings')->with('update-setting-status', 'Global configurations info has been updated successfully!');
                }
            }
        } else {
            return redirect('admin/global-settings');
        }
    }

    /**
     * @description This function is used to upload the profile picture
     * @param Request $request
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadUserImage(Request $request, $user_id) {
        $user = User::find($user_id);
        if ($request->file('profile_picture') != '') {
            $extension = $request->file('profile_picture')->getClientOriginalExtension();
            $path = realpath(dirname(__FILE__) . '/../../../../');
            $new_file_name = time() . "." . $extension;
            $old_file = $path . '/storage/app/public/user-images/' . $new_file_name;
            $new_file = $path . '/storage/app/public/user-images/' . $new_file_name;
            Storage::put('public/user-images/' . $new_file_name, file_get_contents($request->file('profile_picture')->getRealPath()));
            $command = "convert " . $old_file . " -resize 300x200^ " . $new_file;
            exec($command);
            $user->userInformation->profile_picture = $new_file_name;
            $user->userInformation->save();
        }
        return redirect('/admin/view-driver-user/' . $user_id)->with('update-image-success', 'Image has been uploaded successfully!');
    }

    /**
     * @description This function is used to approve the profile picture
     * @param Request $request
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveUserImage(Request $request, $user_id) {
        $user = User::find($user_id);
        if (isset($user->userInformation->profile_picture_temp) && ($user->userInformation->profile_picture_temp != '')) {
            if ($user->userInformation->profile_picture != '') {
                $path = realpath(dirname(__FILE__) . '/../../../../');
                $old_file = $path . '/storage/app/public/user-images/' . $user->userInformation->profile_picture;
                @unlink($old_file);
                $user->userInformation->profile_picture = "";
                $user->userInformation->save();
            }
            $user->userInformation->profile_picture = $user->userInformation->profile_picture_temp;
            $user->userInformation->profile_picture_temp = "";
            $user->userInformation->save();
        }
        return redirect('/admin/update-driver-user/' . $user_id)->with('update-image-success', 'Driver user Image has been approved/updated successfully!');
    }

    /**
     * @description This function is used to show the list-admin-users view
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function listAdminUsers() {
        $all_countries = Country::translatedIn(\App::getLocale())->get();
        return view("admin::list-admin-users", array("all_countries" => $all_countries));
    }

    /**
     * @description This function is used to return the admin user details list
     * @param Request $request
     * @return mixed
     */
    public function listAdminUsersData(Request $request) {
        $order_filter_by = $request->order_filter_by;
        $all_users = UserInformation::where('user_type', '2')->get();
        $admin_users = $all_users;
        /*$admin_users = $all_users->reject(function ($user) {
            return $user->user_type == '1';
        });*/
        if (Auth::user()->userInformation->user_type == '1') {
            $userAddress = UserAddress::where('user_id', Auth::user()->id)->first();
            $country = 0;
            if (isset($userAddress->user_country) && $userAddress->user_country != 17) {
                $country = $userAddress->user_country;
                $admin_users = $all_users->reject(function ($user) use ($country) {
                    $user_country = 0;
                    if ($user->user->userAddress) {
                        foreach ($user->user->userAddress as $address) {
                            $user_country = $address->user_country;
                        }
                    }
                    return ($user->user_type == '1') || ($user->user_type > 1) || ($user_country != $country) || ($user->id == Auth::user()->id) || ($user->user->supervisor_id != Auth::user()->id);
                });
            }
        }
        $search_value = $request->search_value;
        if ($search_value != "") {
            $admin_users = $all_users->reject(function ($user) use ($search_value) {

                $user_country = 0;
                if ($user->user->userAddress) {

                    foreach ($user->user->userAddress as $address) {
                        $user_country = $address->user_country;
                    }
                }
                return ($user_country != $search_value);
            });
        }
        if ($order_filter_by != "") {
            $admin_users = $admin_users->filter(function ($all_data) use ($order_filter_by) {
                return ($all_data->user_status == $order_filter_by);
            });
        }
        $admin_users = $admin_users->sortByDesc('id');
        return Datatables::of($admin_users)
                        ->addColumn('user_id', function ($regsiter_user) {
                            return $regsiter_user->user_id;
                        })
                        ->addColumn('full_name', function ($regsiter_user) {
                            return $regsiter_user->first_name . ' ' . $regsiter_user->last_name;
                        })
                        ->addColumn('email', function ($admin_users) {
                            return $admin_users->user->email;
                        })
                        ->addColumn('country', function ($admin_users) {
                            $location = "";
                            if (isset($admin_users->user->userAddress)) {
                                foreach ($admin_users->user->userAddress as $address) {
                                    if (isset($address->countryinfo)) {

                                        $location .= $address->countryinfo->translate()->name;
                                    }
                                }
                                return $location;
                            } else {
                                return "--";
                            }
                        })
                        ->addColumn('role', function ($admin_users) {
                            $role = "";
                            if (isset($admin_users->user->getRoles()->first()->name)) {
                                $role = $admin_users->user->getRoles()->first()->name;
                            }
                            return $role;
                        })
                        ->addColumn('status', function ($admin_users) {

                            $html = '';
                            if ($admin_users->user_status == 0) {
                                $html = '<div  id="active_div' . $admin_users->user->id . '"    style="display:none;"  >
                                                <a class="btn btn-active" title="Click to Change changeStarUserStatus" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 2);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Active</a> </div>';
                                $html = $html . '<div id="inactive_div' . $admin_users->user->id . '"  style="display:inline-block" >
                                                <a class="btn btn-inactive" title="Click to Change Status" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 1);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Inactive </a> </div>';
                                $html = $html . '<div id="blocked_div' . $admin_users->user->id . '" style="display:none;"  >
                                                <a class="btn btn-inactive" title="Click to Change Status" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 1);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Blocked </a> </div>';
                            } else if ($admin_users->user_status == 2) {
                                $html = '<div  id="active_div' . $admin_users->user->id . '"  style="display:none;" >
                                                <a class="btn btn-active" title="Click to Change Status" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 2);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Active</a> </div>';
                                $html = $html . '<div id="blocked_div' . $admin_users->user->id . '"    style="display:inline-block" >
                                                <a class="btn btn-inactive" title="Click to Change Status" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 1);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Blocked</a> </div>';
                            } else {
                                $html = '<div  id="active_div' . $admin_users->user->id . '"   style="display:inline-block" >
                                                <a class="btn btn-active" title="Click to Change Status" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 2);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Active</a> </div>';
                                $html = $html . '<div id="blocked_div' . $admin_users->user->id . '"  style="display:none;"  >
                                                <a class="btn btn-inactive" title="Click to Change Status" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 1);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Blocked</a> </div>';
                            }
                            return $html;
                        })
                        ->addColumn('created_at', function ($admin_users) {
                            $date = Carbon::createFromTimeStamp(strtotime($admin_users->user->created_at))->format('m-d-Y H:i A');
                            return $date;
                        })
                        ->make(true);
    }

    /**
     * @description This function is used to view admin details
     * @param Request $request
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function viewAdminUser(Request $request, $user_id) {
        $arr_user_data = User::find($user_id);
        $user_country = "0";
        if (isset($arr_user_data->userAddress)) {
            foreach ($arr_user_data->userAddress as $address) {
                $user_country = $address->user_country;
            }
        }
        $user_role = UserRole::where('user_id', $user_id)->first();
        $all_countries = Country::translatedIn(\App::getLocale())->get()->sortBy("name");
        $all_roles = Role::where('slug', 'subadminuser')->first();
        $dashboard_detail = DashboardDetail::where('user_id', $user_id)->first();
        $city = '-';
        if(isset($dashboard_detail)) {
            $city = City::find($dashboard_detail->region);
            $city = $city->name;
        }
        return view("admin::view-admin-user", array('user_country' => $user_country, 'user_info' => $arr_user_data, 'countries' => $all_countries, 'roles' => $all_roles, 'user_role' => $user_role, 'dashboard_detail' => $dashboard_detail, 'city' => $city));
    }

    /**
     * @description This function is used to update admin information
     * @param Request $request
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function updateAdminUser(Request $request, $user_id) {
        $arr_user_data = User::find($user_id);
        if ($arr_user_data) {
            if ($request->method() == "GET") {
                $user_country = "0";
                if (isset($arr_user_data->userAddress)) {
                    foreach ($arr_user_data->userAddress as $address) {
                        $user_country = $address->user_country;
                    }
                }
                $user_role = UserRole::where('user_id', $user_id)->first();
                $all_countries = Country::translatedIn(\App::getLocale())->where('status','1')->get();
                $all_roles = Role::where('slug', 'subadminuser')->get();
                $exist_zone = Zone::where('status', 0)->get();
                $dashboard_Detail = DashboardDetail::where('user_id', $arr_user_data->id)->first();
                $states = State::select(["id"])->with(["cityInfo" => function($query){
                    $query->select(["id", "state_id"]);
                }])->whereCountryId(10)->get();
                return view("admin::edit-admin-user", array('user_country' => $user_country, 'user_info' => $arr_user_data, 'countries' => $all_countries, 'roles' => $all_roles, 'user_role' => $user_role, 'dashboard_Detail' => $dashboard_Detail, 'all_zone' => $exist_zone, 'cities' => $states));
            } elseif ($request->method() == "POST") {
                $data = $request->all();
                $arrUserEmail = User::where("email", $data['email'])->where('id', '!=', $user_id)->get();
                $arrUserEmail = $arrUserEmail->reject(function ($user) {
                    return (($user->userInformation->user_type == 3) || ($user->userInformation->user_type == 2));
                });
                $arrUserMobile = UserInformation::where('user_mobile', $data["user_mobile"])->where('user_id', '!=', $user_id)->whereNotIn('user_type', [2, 3])->get();
                $mob_num_len = $data['mobile_code'] == '+91' ? 10 : 8;
                $data['user_mobile'] = substr($data['user_mobile'], 0, 1) == '0' ? ltrim($data['user_mobile'], "0") : $data['user_mobile'];
                $data['user_mobile'] = str_replace(' ', '', $data['user_mobile']);
                $data['user_mobile'] = str_replace(' ', '', $data['user_mobile']);

                if (count($arrUserEmail) > 0) {
                    $validate_response = Validator::make($data, array(
                                'email' => 'email|max:255|unique:users,email,' . $user_id,
                                    )
                    );
                } elseif (count($arrUserMobile) > 0) {
                    $validate_response = Validator::make($data, array(
                                'user_mobile' => 'required|digits:' . $mob_num_len . '|numeric|unique:user_informations,user_mobile,' . $arr_user_data->userInformation->user_id,
                                    )
                    );
                } else {
                    $validation_rules = array(
                                'gender' => 'required',
                                'first_name' => 'required',
                                'user_mobile' => 'required|digits:' . $mob_num_len . '|numeric',
                                'last_name' => 'required',
                                'country' => 'required',
                                'user_status' => 'required|numeric',
                                'role' => 'required',
                                'default_time_period' => 'required',
                                'region' => 'required',
                                'email' => 'email|max:500'
                                    );

                    if(isset($request->new_password)) {

                        $validation_rules['new_password'] = 'min:7|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9@$!%*?&]*$/';

                        $validation_rules['confirm_password'] = 'same:new_password|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9@$!%*?&]*$/';
                    }

                    $validate_response = Validator::make($data, $validation_rules, array(
                                "new_password.regex" => 'Please enter at least one upper case,lower case,digit and special character!'
                                    )
                    );
                }
                if ($validate_response->fails()) {
                    return redirect('admin/update-admin-user/' . $arr_user_data->id)
                                    ->withErrors($validate_response)
                                    ->withInput();
                } else {
                    /** user information goes here *** */
                    if (isset($data['new_password']) && $data['new_password'] != '') {
                        $arr_user_data->password = isset($data['new_password']) ? $data['new_password'] : '';
                        $arr_user_data->save();
                    }
                    if (isset($data["gender"])) {
                        $arr_user_data->userInformation->gender = $data["gender"];
                    }
                    if (isset($data["user_status"])) {
                        $arr_user_data->userInformation->user_status = $data["user_status"];
                    }

                    if (isset($data["first_name"])) {
                        $arr_user_data->userInformation->first_name = preg_replace('/\s/', '', $data["first_name"]);
                    }
                    if (isset($data["last_name"])) {
                        $arr_user_data->userInformation->last_name = preg_replace('/\s/', '', $data["last_name"]);
                    }
                    if (isset($data["about_me"])) {
                        $arr_user_data->userInformation->about_me = $data["about_me"];
                    }

                    if (isset($data["user_mobile"])) {
                        $arr_user_data->userInformation->user_mobile = $data["user_mobile"];
                    }
                    if (isset($data["mobile_code"]) && $data["mobile_code"] != '') {
                        $arr_user_data->userInformation->mobile_code = str_replace('+', '', $data["mobile_code"]);
                    }
                    if (isset($data["country"])) {
                        $userAddress = UserAddress::where('user_id', $user_id)->first();
                        if (count($userAddress) <= 0) {
                            UserAddress::create(array("user_id" => $user_id));
                            $userAddress = UserAddress::where('user_id', $user_id)->first();
                        }
                        $userAddress->user_country = $data["country"];
                        $userAddress->save();
                    }
                    if ($request->hasFile('profile_picture')) {
                        if (isset($arr_user_data->userInformation->profile_picture) && $arr_user_data->userInformation->profile_picture != '') {
                            $this->removeProfilePictureFromStrorage($arr_user_data->userInformation->profile_picture);
                        }
                        $dir = base_path() . '/' . 'storage/app/public/user-image';
                        if (!is_dir($dir)) {
                            mkdir($dir, 0777, true);
                        }
                        $extension = $request->file('profile_picture')->getClientOriginalExtension();
                        $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
                        $status = file_put_contents($dir . '/' . $new_file_name, file_get_contents($request->file('profile_picture')->getRealPath()));
                        if ($status) {
                            $arr_user_data->userInformation->profile_picture = $new_file_name;
                        }
                    }
                    $arr_user_data->userInformation->save();
                    $userRole = Role::where("id", $data['role'])->first();
                    if (isset($userRole) && count($userRole) > 0) {
                        UserRole::where('user_id', $arr_user_data->id)->delete();
                        $user_role = new UserRole();
                        $user_role->role_id = $userRole->id;
                        $user_role->user_id = $arr_user_data->id;
                        $user_role->save();
                    }
                    $dashboard_Detail = DashboardDetail::where('user_id', $arr_user_data->id)->first();
                    if (isset($dashboard_Detail) && count($dashboard_Detail) > 0) {
                        if (isset($data["default_time_period"])) {
                            $dashboard_Detail->default_time_period = $data["default_time_period"];
                        }
                        if (isset($data["region"])) {
                            $dashboard_Detail->region = $data["region"];
                        }
                        $dashboard_Detail->save();
                    } else {
                        $create_dashboard_detail = new DashboardDetail();
                        $create_dashboard_detail->default_time_period = $data["default_time_period"];
                        $create_dashboard_detail->region = $data["region"];
                        $create_dashboard_detail->user_id = $arr_user_data->id;
                        $create_dashboard_detail->save();
                    }
                    if (trim($data['old_email']) != trim($data['email'])) {
                        $email_send_status = $this->sendEmailOnUpdateAdminUserInfo($data, $arr_user_data->id);
                    }
                    $succes_msg = "Admin user profile updated successfully.";
                    return redirect("admin/view-admin-user/" . $user_id)->with("update-user-status", $succes_msg);
                }
            }
        } else {
            return redirect("admin/admin-users");
        }
    }

    /**
     * @description This function is used to send email for email verify and update email of admin
     * @param $data
     * @param $user_id
     */
    protected function sendEmailOnUpdateAdminUserInfo($data, $user_id) {
        $arr_user_data = User::find($user_id);
        $arr_user_data->email = $data['email'];
        $arr_user_data->save();
        //updating user status to inactive
        $arr_user_data->userInformation->user_status = 0;
        $arr_user_data->userInformation->save();
        //sending email with verification link
        //sending an email to the user on successfull registration.

        $arr_keyword_values = array();
        $activation_code = $this->generateReferenceNumber();
        $site_email = GlobalValues::get('site-email');
        $site_title = GlobalValues::get('site-title');
        //Assign values to all macros
        $arr_keyword_values['FIRST_NAME'] = $arr_user_data->userInformation->first_name;
        $arr_keyword_values['LAST_NAME'] = $arr_user_data->userInformation->last_name;
        $arr_keyword_values['VERIFICATION_LINK'] = url('admin/verify-user-email/' . $activation_code);
        $arr_keyword_values['SITE_TITLE'] = $site_title;
        $arr_keyword_values['SITE_EMAIL'] = $site_email;
        $site_url = GlobalValues::get('site-url');
        $facebook_url = GlobalValues::get('facebook-link');
        $instagram_url = GlobalValues::get('instagram-link');
        $youtube_url = GlobalValues::get('youtube-link');
        $twitter_url = GlobalValues::get('twitter-link');
        $arr_keyword_values['SITE_URL'] = $site_url;
        $arr_keyword_values['FACEBOOK_URL'] = $facebook_url;
        $arr_keyword_values['INSTAGRAM_URL'] = $instagram_url;
        $arr_keyword_values['YOUTUBE_URL'] = $youtube_url;
        $arr_keyword_values['TWITTER_URL'] = $twitter_url;
        // updating activation code
        $arr_user_data->userInformation->activation_code = $activation_code;
        $arr_user_data->userInformation->save();
        if(isset($arr_user_data) && $arr_user_data->email != ""){
            // oommented due to smpt detail delay
            /*@Mail::send('emailtemplate::user-email-change-en', $arr_keyword_values, function ($message) use ($arr_user_data, $site_email, $site_title) {
                $message->to($arr_user_data->email)->subject("Email Changed Successfully!")->from($site_email, $site_title);
            });*/
        }
    }

    /**
     * @description This function is used to update driver user details
     * @param Request $request
     * @param $user_id
     * @param string $doc
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateDriverUser(Request $request,$user_type, $user_id, $doc = '') {
        $exist = 0;
        if ($doc != "") {
            $exist = 1;
        }
        $arr_user_data = User::find($user_id);
        $documents = DriverDocument::translatedIn(\App::getLocale())->get()->toArray();
        $driver_uploaded_document = DriverDocumentInformation::where('user_id',$user_id)->pluck('document_id')->toArray();
        $states = State::translatedIn(\App::getLocale())->get(['id'])->toArray();
        //$cities = City::translatedIn(\App::getLocale())->get()->toArray();
        //$hubs = Hub::where(['hub_status'=>1])->get();
        if ($arr_user_data) {
            if($arr_user_data->userAddress->count() > 0)
            {
                $user_state = $arr_user_data->userAddress[0]->user_state;
                $user_city = $arr_user_data->userAddress[0]->cityTransInfo->name;
                $cities = City::translatedIn(\App::getLocale())->where('state_id',$user_state)->get(['id'])->toArray();
                $hubs = Hub::where(['hub_status'=>'1'])->where('hub_city','LIKE','%'.$user_city.'%')->get();

            }
            if ($request->method() == "GET") {
                return view("admin::edit-driver-user",compact('arr_user_data','documents','states','cities','driver_uploaded_document','hubs'));
                
                /*$country = 0;
                $state = 0;
                $city = 0;
                if (Auth::user()->userAddress) {

                    foreach (Auth::user()->userAddress as $address) {
                        $country = $address->user_country;
                        $state = $address->user_state;
                        $city = $address->user_city;
                    }
                }
                $all_countries = Country::translatedIn(\App::getLocale())->get()->toArray();
                $all_banks = BankDetail::translatedIn(\App::getLocale())->where('status', '1')->get();
                $states = "";
                $cities = "";
                $user_country = 0;
                $user_state = 0;
                $user_state = 0;
                $user_address = "";
                //dd($arr_user_data,$country,$state,$city,$all_countries,$all_banks);
                if (isset($arr_user_data->userAddress)) {
                    foreach ($arr_user_data->userAddress as $address) {
                        $user_country = $address->user_country;
                        $user_state = $address->user_state;
                        $user_city = $address->user_city;
                        $user_address = $address->address;
                    }
                }
                if ($country == '10' && ($user_country != $country)) {
                    return redirect('admin/driver-users');
                }
                $states = State::where('country_id', $user_country)->translatedIn(\App::getLocale())->get();
                $cities = City::where('state_id', $user_state)->where('country_id', $user_country)->translatedIn(\App::getLocale())->get();

                $arr_service_category = Category::translatedIn(\App::getLocale())->get();

                $arr_service = Service::translatedIn(\App::getLocale())->get();

                $userServices = UserServiceInformation::where('user_id', $user_id)->first();
                $userLanguages = UserSpokenlanguageinformation::where('user_id', $user_id)->get();
                $paymentMethods = PaymentMethod::all();
                $userPaymentMethods = UserPaymentMethod::where('user_id', $user_id)->get();
                $all_Spokenlangusge = SpokenLanguage::all();
                $all_company_info = CompanyInformation::where('user_id', $user_id)->first();
                $nationality = Nationality::where('id', '!=', '103')->orderBy('country_name', 'ASC')->get();
                $allCompanies = array();

                if (Auth::user()->userInformation->user_type == '1') {
                    $country = 0;
                    $state = 0;
                    $city = 0;
                    $driver_country = 0;
                    $driver_state = 0;
                    $driver_city = 0;
                    if (Auth::user()->userAddress) {
                        foreach (Auth::user()->userAddress as $address) {
                            $country = $address->user_country;
                            $state = $address->user_state;
                            $city = $address->user_city;
                        }
                    }
                    $compnies = UserInformation::where('user_type', '5')->get();
                    $allCompanies = $compnies->reject(function ($user) use ($country, $state, $city) {
                        if ($user->user->userAddress) {
                            foreach ($user->user->userAddress as $address) {
                                $driver_country = $address->user_country;
                                $driver_state = $address->user_state;
                                $driver_city = $address->user_city;
                            }
                        }
                        $condition = false;
                        $contry_passed = false;
                        $state_passed = false;
                        $city_passed = false;
                        if ($country != '3') {
                            if ($country != '17' && $country != 0) {
                                $contry_passed = ($driver_country != $country);
                            }
                            if ($state != '32' && $state != 0) {
                                $state_passed = ($driver_state != $state);
                            }
                            if ($city != '22' && $city != 0) {
                                $city_passed = ($driver_city != $city);
                            }
                            return ($condition || ($contry_passed || $state_passed || $city_passed));
                        } else {
                            $contry_passed = ($driver_country != $country);
                            if ($state != '5' && $state != 0) {
                                return ($condition || ($contry_passed));
                            } else {
                                return ($condition || ($contry_passed || $state_passed));
                            }
                        }
                    });
                }

                $user_vehicles = UserVehicleInformation::where('user_id', $user_id)->get();
                $user_vehicles = $user_vehicles->reject(function ($vehicle_info) {
                    $is_assigned = DriverAssignedDetail::where('vehicle_id', $vehicle_info->id)->first();
                    if (count($is_assigned) > 0) {
                        return true;
                    }
                });
                //get  driver assigned vehicle details
                $driverVehicle = DriverAssignedDetail::where('user_id', $user_id)->first();
                $driverOtherInfo = driverUserInformation::where('user_id', $user_id)->first();
                $driverBankDetails = UserBankDetail::where('user_id', $user_id)->first();
                $driverDocuments = DriverDocument::where('user_id', $user_id)->get();
                $all_document = Document::all();
                $document_id = array();
                foreach ($all_document as $document) {
                    $document_id[] = $document->id;
                }
                $exitDriverDocumentinfo = DriverDocumentInformation::where('user_id', $user_id)->whereIn('document_id', $document_id)->orderBy('document_id')->get()->toArray();
                $exitdocument_id = array();
                foreach ($exitDriverDocumentinfo as $exitdocument) {
                    $exitdocument_id[] = $exitdocument['document_id'];
                }
                $all_docs_array = array();
                if (isset($all_document) && count($all_document) > 0) {
                    foreach ($all_document as $key => $docs) {
                        if (isset($exitDriverDocumentinfo[$key]) && $docs->id == $exitDriverDocumentinfo[$key]['document_id']) {
                            $all_docs_array[] = $exitDriverDocumentinfo[$key];
                        } else {
                            $all_docs_array[] = array();
                        }
                    }
                }

                $car_model = array();
                $car_color = array();
                $year_manufacture = array();
                $car_model = CarModel::all();
                $car_color = CarColor::all();
                $static_previous_year = 2012;
                $current_date = date('Y', strtotime('+1 years'));
                $difference = abs($static_previous_year - $current_date);
                for ($i = 0; $i <= $difference; $i++) {
                    $year_manufacture[] = $current_date - $i;
                }
                $sql = "SELECT final_amout, SUM(COALESCE(CASE WHEN transaction_type = '1' THEN final_amout END,0)) total_debits , SUM(COALESCE(CASE WHEN transaction_type = '0' THEN final_amout END,0)) total_credits , (SUM(COALESCE(CASE WHEN transaction_type = '0' THEN final_amout END,0)) - SUM(COALESCE(CASE WHEN transaction_type = '1' THEN final_amout END,0))) balance FROM " . DB::getTablePrefix() . "user_wallet_details WHERE user_id=" . $user_id . " AND payment_receipt_flag='0' GROUP BY user_id HAVING balance <> 0";
                $user_wallet_data = DB::select(DB::raw($sql));
                $all_wallet_data = array();
                if (isset($user_wallet_data) && count($user_wallet_data)) {
                    $all_wallet_data = (array) $user_wallet_data[0];
                }
                $currencyCode = $this->getUserCurrencyCode($user_id);

                return view("admin::edit-driver-user", array('exist' => $exist, 'driver_bank_details' => $driverBankDetails, 'all_banks' => $all_banks, "document_id" => $document_id, "user_id" => $user_id, "all_document" => $all_document, "exitDriverDocumentinfo" => $all_docs_array, "driverDocuments" => $driverDocuments, "driverOtherInfo" => $driverOtherInfo, "companies" => $allCompanies, 'company_info' => $all_company_info, 'nationality' => $nationality, 'max_range' => '0', 'user_payment_methods' => $userPaymentMethods, 'payment_methods' => $paymentMethods, 'user_info' => $arr_user_data, "countries" => $all_countries, "driver_state" => $driver_state, "driver_country" => $driver_country, "driver_city" => $driver_city, "address" => $user_address, "cities" => $cities, "states" => $states, "categories" => $arr_service_category, "services" => $arr_service, "user_services" => $userServices, "languages" => $all_Spokenlangusge, "user_languages" => $userLanguages, "user_vehicles" => $user_vehicles, "driverVehicle" => $driverVehicle, "car_model" => $car_model, "car_color" => $car_color, "year_manufacture" => $year_manufacture, 'all_wallet_data' => $all_wallet_data, "currencyCode" => $currencyCode));*/
            } elseif ($request->method() == "POST") {
                $data = $request->all();
                $mob_num_len = $data['mobile_code'] == '+91' ? 10 : 8;
                $data['user_mobile'] = substr($data['user_mobile'], 0, 1) == '0' ? ltrim($data['user_mobile'], "0") : $data['user_mobile'];
                $data['user_mobile'] = str_replace(' ', '', $data['user_mobile']);
                $data['mobile_code'] = str_replace('+', '', $data['mobile_code']);
                $arrUserEmail = User::where("email", $data['email'])->where('id', '!=', $user_id)->get();
                $arrUserEmail = $arrUserEmail->filter(function ($user) {
                    if (isset($user->userInformation)) {
                        return $user->userInformation->user_type == 2;
                    }
                });
                $arrUserMobile = UserInformation::where("user_mobile", $data['user_mobile'])->where('user_id', '!=', $user_id)->where('user_type', 2)->first();
                if (Auth::user()->userInformation->user_type != 4) {
                    if (count($arrUserEmail) > 0) {
                        $validate_response = Validator::make($data, array(
                                    'email' => 'email|max:255|unique:users,email,' . $user_id,
                                        )
                        );
                    } elseif (count($arrUserMobile) > 0) {
                        $validate_response = Validator::make($data, array(
                                    'user_mobile' => 'required|digits:' . $mob_num_len . '|numeric|unique:user_informations,user_mobile,' . $arr_user_data->userInformation->id,
                                        )
                        );
                    } else {
                        $validate_response = Validator::make($data, array(
                                    'first_name' => 'required',
                                    'last_name' => 'required',
                                    'nationality' => 'required',
                                    'hub_id' => 'required',
                                    'civil_id' => 'required|min:12|unique:user_informations,civil_id,' . $arr_user_data->userInformation->id,
                                    'taxi_type' => 'required',
                                    'new_password' => 'min:7|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9@$!%*?&]*$/',
                                    'password_confirmation' => 'min:7|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9@$!%*?&]*$/|same:new_password',
                                        ), array(
                                    "new_password.regex" => 'Please enter a valid password(allowed special charactors (@$!%*?&))'
                                        )
                        );
                    }
                } else {
                    if (count($arrUserEmail) > 0) {
                        $validate_response = Validator::make($data, array(
                                    'email' => 'email|max:255|unique:users,email,' . $user_id,
                                        )
                        );
                    } elseif (count($arrUserMobile) > 0) {
                        $validate_response = Validator::make($data, array(
                                    'user_mobile' => 'required|digits:' . $mob_num_len . '|numeric|unique:user_informations,user_mobile,' . $arr_user_data->userInformation->id,
                                        )
                        );
                    } else {
                        $validate_response = Validator::make($data, array(
                                    'first_name' => 'required|regex:/^[a-zA-Z]+$/u',
                                    'last_name' => 'required|regex:/^[a-zA-Z]+$/u',
                                    'nationality' => 'required',
                                    'hub_id' => 'required',
                                    'taxi_type' => 'required',
                                    'civil_id' => 'required|min:12|unique:user_informations,civil_id,' . $arr_user_data->userInformation->id,
                                    'new_password' => 'min:7|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9@$!%*?&]*$/',
                                    'password_confirmation' => 'min:7|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9@$!%*?&]*$/|same:new_password',
                                        ), array(
                                    "new_password.regex" => 'Please enter a valid password(allowed special charactors (@$!%*?&))'
                                        )
                        );
                    }
                }
                if ($validate_response->fails()) {

                    return redirect('admin/update-driver-user/' . $arr_user_data->id)
                                    ->withErrors($validate_response)
                                    ->withInput();
                } else {
                    /** user information goes here *** */
                    if (isset($data["gender"])) {
                        $arr_user_data->userInformation->gender = $data["gender"];
                    }
                    if (isset($data["user_status"])) {
                        $arr_user_data->userInformation->user_status = $data["user_status"];
                    }

                    if (isset($data["first_name"])) {
                        $arr_user_data->userInformation->first_name = preg_replace('/\s/', '', $data["first_name"]);
                    }
                    if (isset($data["working_time"])) {
                        $arr_user_data->userInformation->working_time = $data["working_time"];
                    }
                    if (isset($data["last_name"])) {
                        $arr_user_data->userInformation->last_name = preg_replace('/\s/', '', $data["last_name"]);
                    }
                    if (isset($data["about_me"])) {
                        $arr_user_data->userInformation->about_me = $data["about_me"];
                    }
                    if (isset($data["nationality"])) {
                        $arr_user_data->userInformation->nationality = $data["nationality"];
                    }

                    if (isset($data["user_mobile"])) {
                        $arr_user_data->userInformation->user_mobile = $data["user_mobile"];
                    }
                    if (isset($data["mobile_code"]) && $data["mobile_code"] != '') {
                        $arr_user_data->userInformation->mobile_code = $data["mobile_code"];
                    }
                    if (isset($data["date_of_birth"])) {
                        $arr_user_data->userInformation->user_birth_date = $data["date_of_birth"];
                    }

                    if (isset($data["type"])) {
                        $arr_user_data->userInformation->is_company = $data["type"];
                    }
                    if (isset($data["owner_name"])) {
                        $arr_user_data->userInformation->owner_name = $data["owner_name"];
                    }
                    if (isset($data["owner_number"])) {
                        $arr_user_data->userInformation->owner_number = $data["owner_number"];
                    }

                    if (Auth::user()->userInformation->user_type != 4) {
                        $user_address = UserAddress::where('user_id', $user_id)->first();
                    }
                    if ($request->hasFile('profile_picture')) {
                        if (isset($arr_user_data->userInformation->profile_picture) && $arr_user_data->userInformation->profile_picture != '') {
                            $this->removeProfilePictureFromStrorage($arr_user_data->userInformation->profile_picture);
                        }
                        $dir = base_path() . '/' . 'storage/app/public/user-images';
                        if (!is_dir($dir)) {
                            mkdir($dir, 0777, true);
                        }
                        $extension = $request->file('profile_picture')->getClientOriginalExtension();
                        $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
                        $status = file_put_contents($dir . '/' . $new_file_name, file_get_contents($request->file('profile_picture')->getRealPath()));
                        if ($status) {
                            $arr_user_data->userInformation->profile_picture = $new_file_name;
                        }
                    }

                    $arr_user_data->userInformation->civil_id = isset($data["civil_id"]) ? $data["civil_id"] : '';
                    $arr_user_data->userInformation->save();
                    
                    $arr_user_data->driverUserInformation->hub_id = $data['hub_id'];
                    $arr_user_data->driverUserInformation->save();

                    if (isset($data['taxi_type']) && $data['taxi_type'] != '') {
                        $arr_services = UserServiceInformation::where('user_id', $arr_user_data->id)->first();
                        if (isset($arr_services) && count($arr_services) > 0) {
                            $arr_services->service_id = $data['taxi_type'];
                        } else {
                            $arr_services = new UserServiceInformation();
                            $arr_services->user_id = $arr_user_data->id;
                            $arr_services->service_id = $data['taxi_type'];
                        }
                        $arr_services->save();
                    }
                    if ($data['user_mobile'] != $data["old_user_mobile"]) {
                        $driver_mobile_history = new DriverMobileNumberHistory();
                        $driver_mobile_history->driver_id = $arr_user_data->id;
                        $driver_mobile_history->old_user_mobile = $data["old_user_mobile"];
                        $driver_mobile_history->save();
                    }
                    // addding user company details
                    if (isset($data["type"]) && $data["type"] == '1') {
                        $company_id = isset($data["comp_name"]) ? $data["comp_name"] : "0";
                        if ($company_id > 0) {
                            $user_data = User::where('id', $user_id)->first();
                            $user_data->company_id = $company_id;
                            $user_data->save();
                        }
                    } else {
                        $arr_CompanyDetails = CompanyInformation::where('user_id', $user_id)->first();
                        if (isset($arr_CompanyDetails) && count($arr_CompanyDetails) > 0) {
                            $arr_CompanyDetails->name = "";
                            $arr_CompanyDetails->description = "";
                            $arr_CompanyDetails->comp_reg_no = "";
                            $arr_CompanyDetails->save();
                        }
                    }

                    if (trim($data['old_email']) != trim($data['email'])) {
                        if ($arr_user_data->userInformation->facebook_id == '' && $arr_user_data->userInformation->twitter_id == '' && $arr_user_data->userInformation->google_id == '') {
                            $email_send_status = $this->sendEmailOnChangeDriverUserEmail($data, $arr_user_data->id);
                        } else {
                            $error_msg = "You Can't change the email id because user is logged in by facebook!";
                            return redirect()->back()->with("email-update-fail", $error_msg);
                        }
                    }
                    if (isset($data["new_password"]) && $data["new_password"] != '') {
                        if ($arr_user_data->userInformation->facebook_id == '' && $arr_user_data->userInformation->twitter_id == '' && $arr_user_data->userInformation->google_id == '') {
                            $arr_user_data->password = $data["new_password"];
                            $arr_user_data->save();
                        } else {
                            $succes_msg = "You Can't change the password because user is logged in by facebook!";
                            return redirect()->back()->with("password-update-fail", $succes_msg);
                        }
                    }
                    $succes_msg = "Driver user profile has been updated successfully!";
                    return redirect("admin/update-driver-user/" . $arr_user_data->id)->with("profile-updated", $succes_msg);
                }
            }
        } else {

            return redirect("admin/driver-users");
        }
    }

    /**
     * @description This function is used to send email for email verify and change email
     * @param $data
     * @param $user_id
     */
    protected function sendEmailOnChangeDriverUserEmail($data, $user_id) {
        $arr_user_data = User::find($user_id);
        $arr_user_data->email = $data['email'];
        $arr_user_data->save();

        //updating user status to inactive
        $arr_user_data->userInformation->user_status = 0;
        $arr_user_data->userInformation->save();
        //sending email with verification link
        //sending an email to the user on successfull registration.

        $arr_keyword_values = array();
        $site_email = GlobalValues::get('site-email');
        $site_title = GlobalValues::get('site-title');
        $activation_code = $this->generateReferenceNumber();
        //Assign values to all macros
        $arr_keyword_values['FIRST_NAME'] = $arr_user_data->userInformation->first_name;
        $arr_keyword_values['LAST_NAME'] = $arr_user_data->userInformation->last_name;
        $arr_keyword_values['VERIFICATION_LINK'] = url('verify-user-email/' . $activation_code);
        $arr_keyword_values['SITE_TITLE'] = $site_title;
        $arr_keyword_values['SITE_EMAIL'] = $site_email;
        $site_url = GlobalValues::get('site-url');
        $facebook_url = GlobalValues::get('facebook-link');
        $instagram_url = GlobalValues::get('instagram-link');
        $youtube_url = GlobalValues::get('youtube-link');
        $twitter_url = GlobalValues::get('twitter-link');
        $arr_keyword_values['SITE_URL'] = $site_url;
        $arr_keyword_values['FACEBOOK_URL'] = $facebook_url;
        $arr_keyword_values['INSTAGRAM_URL'] = $instagram_url;
        $arr_keyword_values['YOUTUBE_URL'] = $youtube_url;
        $arr_keyword_values['TWITTER_URL'] = $twitter_url;
        // updating activation code
        $arr_user_data->userInformation->activation_code = $activation_code;
        $arr_user_data->userInformation->save();
        if(isset($arr_user_data) && $arr_user_data->email != ""){
            // oommented due to smpt detail delay
            /*@Mail::send('emailtemplate::user-email-change-en', $arr_keyword_values, function ($message) use ($arr_user_data, $site_email, $site_title) {
                $message->to($arr_user_data->email)->subject("Email Changed Successfully!")->from($site_email, $site_title);
            });*/
        }
    }

    /**
     * @description This function is used to change password and send email for password change
     * @param $data
     * @param $user_id
     */
    protected function sendEmailOnChangeDriverUserPassword($data, $user_id) {
        //updating user Password
        $arr_user_data = User::find($user_id);
        $arr_user_data->password = $data['password'];
        $arr_user_data->save();
        $site_email = GlobalValues::get('site-email');
        $site_title = GlobalValues::get('site-title');
        //Assign values to all macros
        $arr_keyword_values['FIRST_NAME'] = $arr_user_data->userInformation->first_name;
        $arr_keyword_values['LAST_NAME'] = $arr_user_data->userInformation->last_name;
        $arr_keyword_values['PASSWORD'] = $data['password'];
        $arr_keyword_values['SITE_TITLE'] = $site_title;
        $site_url = GlobalValues::get('site-url');
        $facebook_url = GlobalValues::get('facebook-link');
        $instagram_url = GlobalValues::get('instagram-link');
        $youtube_url = GlobalValues::get('youtube-link');
        $twitter_url = GlobalValues::get('twitter-link');
        $arr_keyword_values['SITE_URL'] = $site_url;
        $arr_keyword_values['FACEBOOK_URL'] = $facebook_url;
        $arr_keyword_values['INSTAGRAM_URL'] = $instagram_url;
        $arr_keyword_values['YOUTUBE_URL'] = $youtube_url;
        $arr_keyword_values['TWITTER_URL'] = $twitter_url;

        if (isset($arr_user_data) && $arr_user_data->email != '') {
            // oommented due to smpt detail delay
            /*@Mail::send('emailtemplate::password-change-en', $arr_keyword_values, function ($message) use ($arr_user_data, $site_email, $site_title) {
                $message->to($arr_user_data->email)->subject("Password changed Successfully!")->from($site_email, $site_title);
            });*/
        }
    }

    /**
     * @description This function is used to create user
     * @param Request $request
     * @param bool $is_admin
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|View
     */
    public function createUser(Request $request, $is_admin = false) {
        if ($request->method() == "GET") {
            $all_countries = Country::translatedIn(\App::getLocale())->where('status','1')->first();
            //$all_roles = Role::where('slug', 'subadminuser')->get();
            $all_roles = Role::where('slug', '<>', 'superadmin')->where('slug', '<>', 'registered.user')->get();
//            $filtered_reg_role = $all_roles->filter(function ($value, $key) {
//                        return $value->slug == 'registered.user';
//                    })->first();

            return view("admin::create-admin-user", array('roles' => $all_roles, 'is_admin' => $is_admin, "countries" => $all_countries));
        } elseif ($request->method() == "POST") {

            //alam 26-02-2020

            //$validated = $request->validated();

            $data = $request->all();
            $created_user = User::create(array(
                        'email' => $data['email'],
                        'password' => ($data['password']),
                        'username' => ($data['email']),
                        'supervisor_id' => Auth::user()->id
            ));

            // update User Information
            //Adjusted user specific columns, which may not passed on front end and adjusted with the default values
            $data["user_type"] = isset($data["user_type"]) ? $data["user_type"] : "1";    // 1 may have several mean as per enum stored in the database. Here we 
            // took 1 means one of the front end registered users
            $data["user_status"] = isset($data["user_status"]) ? $data["user_status"] : "0";  // 0 means not active
            $data["gender"] = isset($data["gender"]) ? $data["gender"] : "3";       // 3 means not specified
            $data["profile_picture"] = isset($data["profile_picture"]) ? $data["profile_picture"] : "";
            $data["facebook_id"] = isset($data["facebook_id"]) ? $data["facebook_id"] : "";
            $data["twitter_id"] = isset($data["twitter_id"]) ? $data["twitter_id"] : "";
            $data["google_id"] = isset($data["google_id"]) ? $data["google_id"] : "";
            $data["user_birth_date"] = isset($data["user_birth_date"]) ? $data["user_birth_date"] : "";
            $data["first_name"] = isset($data["first_name"]) ? preg_replace('/\s/', '', $data["first_name"]) : "";
            $data["last_name"] = isset($data["last_name"]) ? preg_replace('/\s/', '', $data["last_name"]) : "";
            $data["about_me"] = isset($data["about_me"]) ? $data["about_me"] : "";
            $data["user_mobile"] = isset($data["user_mobile"]) ? $data["user_mobile"] : "";
            $data["mobile_code"] = isset($data["mobile_code"]) ? str_replace('+', '', $data["mobile_code"]) : '965';
            $arr_userinformation = array();
            $arr_userinformation["profile_picture"] = $data["profile_picture"];
            $arr_userinformation["gender"] = $data["gender"];
            $arr_userinformation["activation_code"] = "";             // By default it'll be no activation code
            $arr_userinformation["facebook_id"] = $data["facebook_id"];
            $arr_userinformation["twitter_id"] = $data["twitter_id"];
            $arr_userinformation["google_id"] = $data["google_id"];
            $arr_userinformation["user_birth_date"] = $data["user_birth_date"];
            $arr_userinformation["first_name"] = $data["first_name"];
            $arr_userinformation["last_name"] = $data["last_name"];
            $arr_userinformation["about_me"] = $data["about_me"];
            $arr_userinformation["user_mobile"] = $data["user_mobile"];
            $arr_userinformation["mobile_code"] = $data["mobile_code"];
            $arr_userinformation["user_status"] = $data["user_status"];
            $arr_userinformation["user_type"] = $data["user_type"];
            $arr_userinformation["user_id"] = $created_user->id;
            if ($request->hasFile('profile_picture')) {
                $dir = base_path() . '/' . 'storage/app/public/user-image';
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }
                $extension = $request->file('profile_picture')->getClientOriginalExtension();
                $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
                $status = file_put_contents($dir . '/' . $new_file_name, file_get_contents($request->file('profile_picture')->getRealPath()));
                if ($status) {
                    $arr_userinformation['profile_picture'] = $new_file_name;
                }
            }
            $updated_user_info = UserInformation::create($arr_userinformation);
            /*if (!(Auth::user()->userInformation->user_type == '1'))
            {
                $arr_userAddress["user_country"] = $request->country;
            }
            else
            {
                if (Auth::user()->userAddress)
                {
                    foreach (Auth::user()->userAddress as $address)
                    {
                        $country = $address->user_country;
                        $arr_userAddress["user_country"] = $country;
                    }
                }
            }*/

            $arr_userAddress["user_country"] = $request->country;
            $arr_userAddress["user_id"] = $created_user->id;

            $updated_user_address = UserAddress::create($arr_userAddress);

            $userRole = Role::where("id", $data['role'])->first();
            $created_user->attachRole($userRole);
            $created_user->save();
            if (isset($userRole) && count($userRole) > 0) {
                $user_role = new UserRole();
                $user_role->role_id = $userRole->id;
                $user_role->user_id = $created_user->id;
                $user_role->save();
            }
            $arr_keyword_values = array();
            $site_email = GlobalValues::get('site-email');
            $site_title = GlobalValues::get('site-title');
            $activation_code = $this->generateReferenceNumber();
            //Assign values to all macros
            $arr_keyword_values['FIRST_NAME'] = $updated_user_info->first_name;
            $arr_keyword_values['LAST_NAME'] = $updated_user_info->last_name;
            $arr_keyword_values['VERIFICATION_LINK'] = url('verify-user-email/' . $activation_code);
            $arr_keyword_values['SITE_TITLE'] = $site_title;
            $site_url = GlobalValues::get('site-url');
            $facebook_url = GlobalValues::get('facebook-link');
            $instagram_url = GlobalValues::get('instagram-link');
            $youtube_url = GlobalValues::get('youtube-link');
            $twitter_url = GlobalValues::get('twitter-link');
            $arr_keyword_values['SITE_URL'] = $site_url;
            $arr_keyword_values['FACEBOOK_URL'] = $facebook_url;
            $arr_keyword_values['INSTAGRAM_URL'] = $instagram_url;
            $arr_keyword_values['YOUTUBE_URL'] = $youtube_url;
            $arr_keyword_values['TWITTER_URL'] = $twitter_url;
            // updating activation code
            $updated_user_info->activation_code = $activation_code;
            $updated_user_info->save();
            if (isset($created_user->email) && $created_user->email != '') {
                
            }
            return redirect('admin/admin-users')
                            ->with("update-user-status", "admin user has been created successfully");
        }
    }



    public function checkSubadminEmail(Request $request)
    {
        $email = $request->email;
        if(isset($email))
        {
            $check = User::where('email',$email)->exists();
            if($check)
            {
                return 'false';
            }
            else
            {
                return 'true';
            }
        }
    }



    public function checkSubadminEmailUpdate(Request $request)
    {
        $email = $request->email;
        $id = $request->id;
        if(isset($email))
        {
            $check = User::where('email',$email)->where('id','<>',$id)->exists();
            if($check)
            {
                return 'false';
            }
            else
            {
                return 'true';
            }
        }
    }


    public function checkSubadminMobile(Request $request)
    {
        $user_mobile = $request->user_mobile;
        if(isset($user_mobile))
        {
            $check = UserInformation::where('user_mobile',$user_mobile)->orWhere('alternate_number',$user_mobile)->exists();
            if($check)
            {
                return 'false';
            }
            else
            {
                return 'true';
            }
        }
    }

    public function checkSubadminMobileUpdate(Request $request)
    {
        $user_mobile = $request->user_mobile;
        $id = $request->id;
        if(isset($user_mobile))
        {
            $check = UserInformation::where('user_mobile',$user_mobile)->where('user_id','<>',$id)->exists();
            if($check)
            {
                return 'false';
            }
            else
            {
                return 'true';
            }
        }
    }

    /**
     * @description This function is used to showing list-country view
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function listCountries() {
        return view('admin::list-countries');
    }

    /**
     * @description This function is used to get country data
     * @return mixed
     */
    public function listCountriesData() {
        $user = Auth::user();
        /*if ($user->userInformation->user_type == '1' && $user->hasRole('superadmin')) {
            $all_countries = Country::translatedIn(\App::getLocale())->where('status',1)->get();
        }*/
        if ($user->userInformation->user_type == '1') {
            $all_countries = Country::translatedIn(\App::getLocale())->where('status',1)->get();
        }else {
            $userAddress = UserAddress::where('user_id', $user->id)->first();

            if (isset($userAddress->user_country)) {
                if ($userAddress->user_country == '17') {
                    $all_countries = Country::translatedIn(\App::getLocale())->get();
                } else {
                    $all_countries = Country::translatedIn(\App::getLocale())->get();
                    $all_countries = $all_countries->reject(function ($country) use ($userAddress) {
                        return ($country->id != $userAddress->user_country);
                    });
                }
            }
        }
        $all_countries = $all_countries->reject(function ($country) {
            return ($country->id == 17);
        });
        return Datatables::collection($all_countries)
                        ->addColumn('Language', function ($country) {
                            $language = '<div class="td_content"><div class="custom_select"><select onchange="selectCountryLang(this)" data-placeholder="Choose a Language...">';
                            $language .= '<option value="" disabled selected>Select Language</option>';
                            if (count(config("translatable.locales_to_display"))) {
                                foreach (config("translatable.locales_to_display") as $locale => $locale_full_name) {
                                    if ($locale != 'en') {
                                        $language .= '<option id="' . $country->id . '" value="' . $locale . '">' . $locale_full_name . '</option>';
                                    }
                                }
                            }
                            return $language;
                        })
                        ->addColumn("created_at", function ($country) {
                            $date = Carbon::createFromTimeStamp(strtotime($country->created_at))->format('m-d-Y H:i A');
                            return $date;
                        })
                        ->addColumn("updated_at", function ($country) {
                            $date = Carbon::createFromTimeStamp(strtotime($country->updated_at))->format('m-d-Y H:i A');
                            return $date;
                        })
                        ->make(true);
    }

    /**
     * @description This function is used to create geocity
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|View
     */
    public function createGeoCityetting(Request $request) {
        if ($request->method() == "GET") {
            $cityData = City::all();
            return view("admin::create-gei-city-limit", array("city_data" => $cityData));
        } else {
            // validate and proceed
            $data = $request->all();
            $validate_response = Validator::make($data, array(
                        'location1' => 'required',
                        'location2' => 'required',
                        'city' => 'required',
            ));

            if ($validate_response->fails()) {
                return redirect()->back()->withErrors($validate_response)->withInput();
            } else {

                $location1_lat = $request->location1_lat;
                $location1_long = $request->location1_long;

                $location2_lat = $request->location2_lat;
                $location2_long = $request->location2_long;
                $url = "https://maps.googleapis.com/maps/api/directions/json?origin=$location1_lat,$location1_long&destination=$location2_lat,$location2_long&key=AIzaSyAJaSQL93o9brPgYRqMAam6KfG5kiBjo0g";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                $response = curl_exec($ch);
                curl_close($ch);
                $response_a = json_decode($response, true);
                $northeast_lat = isset($response_a['routes'][0]['bounds']['northeast']['lat']) ? $response_a['routes'][0]['bounds']['northeast']['lat'] : '';
                $northeast_long = isset($response_a['routes'][0]['bounds']['northeast']['lat']) ? $response_a['routes'][0]['bounds']['northeast']['lng'] : '';
                $southwest_lat = isset($response_a['routes'][0]['bounds']['southwest']['lat']) ? $response_a['routes'][0]['bounds']['southwest']['lat'] : '';
                $southwest_long = isset($response_a['routes'][0]['bounds']['southwest']['lat']) ? $response_a['routes'][0]['bounds']['southwest']['lng'] : '';

                $arrGEOCity = array();
                $arrGEOCity['city_id'] = $request->city;
                $arrGEOCity['location1'] = $request->location1;
                $arrGEOCity['location2'] = $request->location2;
                $arrGEOCity['southwest_lat'] = $southwest_lat;
                $arrGEOCity['southwest_long'] = $southwest_long;
                $arrGEOCity['northeast_lat'] = $northeast_lat;
                $arrGEOCity['northeast_long'] = $northeast_long;
                $arrGEOCity['location1_lat'] = $location1_lat;
                $arrGEOCity['location1_long'] = $location1_long;
                $arrGEOCity['location2_lat'] = $location2_lat;
                $arrGEOCity['location2_long'] = $location2_long;

                GeoLimit::create($arrGEOCity);
                return redirect('admin/city-geo-settings/list')->with('country-status', 'Country has been created Successfully!');
            }
        }
    }

    /**
     * @description This function is used to update geocity
     * @param Request $request
     * @param int $geo_id
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|View
     */
    public function updateGeoCitySetting(Request $request, $geo_id = 0) {
        if ($request->method() == "GET") {
            $cityData = City::all();
            $geoLimitData = GeoLimit::where('id', $geo_id)->first();
            return view("admin::update-geo-city-limit", array("geo_id" => $geo_id, "geo_limit_data" => $geoLimitData, "city_data" => $cityData));
        } else {
            // validate and proceed
            $data = $request->all();
            $validate_response = Validator::make($data, array(
                        'location1' => 'required',
                        'location2' => 'required',
                        'city' => 'required',
            ));

            if ($validate_response->fails()) {
                return redirect()->back()->withErrors($validate_response)->withInput();
            } else {

                $location1_lat = $request->location1_lat;
                $location1_long = $request->location1_long;

                $location2_lat = $request->location2_lat;
                $location2_long = $request->location2_long;
                $url = "https://maps.googleapis.com/maps/api/directions/json?origin=$location1_lat,$location1_long&destination=$location2_lat,$location2_long&key=AIzaSyAJaSQL93o9brPgYRqMAam6KfG5kiBjo0g";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                $response = curl_exec($ch);
                curl_close($ch);
                $response_a = json_decode($response, true);
                $northeast_lat = isset($response_a['routes'][0]['bounds']['northeast']['lat']) ? $response_a['routes'][0]['bounds']['northeast']['lat'] : '';
                $northeast_long = isset($response_a['routes'][0]['bounds']['northeast']['lat']) ? $response_a['routes'][0]['bounds']['northeast']['lng'] : '';
                $southwest_lat = isset($response_a['routes'][0]['bounds']['southwest']['lat']) ? $response_a['routes'][0]['bounds']['southwest']['lat'] : '';
                $southwest_long = isset($response_a['routes'][0]['bounds']['southwest']['lat']) ? $response_a['routes'][0]['bounds']['southwest']['lng'] : '';

                $geoLimitData = GeoLimit::where('id', $geo_id)->first();
                $geoLimitData->city_id = $request->city;
                $geoLimitData->location1 = $request->location1;
                $geoLimitData->location2 = $request->location2;
                $geoLimitData->southwest_lat = $southwest_lat;
                $geoLimitData->southwest_long = $southwest_long;
                $geoLimitData->northeast_lat = $northeast_lat;
                $geoLimitData->northeast_long = $northeast_long;
                $geoLimitData->location1_lat = $location1_lat;
                $geoLimitData->location1_long = $location1_long;
                $geoLimitData->location2_lat = $location2_lat;
                $geoLimitData->location2_long = $location2_long;
                $geoLimitData->save();
                return redirect('admin/city-geo-settings/list')->with('country-status', 'Country has been created Successfully!');
            }
        }
    }

    /**
     * @description This function is used to show list-geo-city-limits view
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function listGeoCitiesSettings() {
        $user = Auth::user();
        if ($user) {
            return view('admin::list-geo-city-limits');
        }
    }

    /**
     * @description This function is used to get geosetting data
     * @return mixed
     */
    public function listGeoSettingsData() {
        $user = Auth::user();
        if ($user) {
            $allCityGeoSettings = GeoLimit::all();
            return Datatables::collection($allCityGeoSettings)
                            ->addColumn('city', function ($setting) {
                                $city = City::where('id', $setting->city_id)->first();
                                return (isset($city->name) ? $city->name : '');
                            })->make(true);
        }
    }

    /**
     * @description This function is used to create new country
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|View
     */
    public function createCountry(Request $request) {
        if ($request->method() == "GET") {
            $arr_service = Service::translatedIn(\App::getLocale())->get();
            return view("admin::create-country", array('services' => $arr_service));
        } else {
            // validate and proceed
            $data = $request->all();
            $validate_response = Validator::make($data, array(
                        'name' => 'required|unique:country_translations,name',
            ));

            if ($validate_response->fails()) {
                return redirect()->back()->withErrors($validate_response)->withInput();
            } else {
                $country = Country::create();
                $en_country = $country->translateOrNew(\App::getLocale());

                $en_country->name = $request->name;
                $en_country->country_id = $country->id;
                $en_country->save();

                $arr_service = Service::translatedIn(\App::getLocale())->get();
                $new_service_id = preg_split("/\,/", $request->new_service_id[0]);
                $new_fixed_fees = preg_split("/\,/", $request->new_fixed_fees[0]);
                $new_ride_starting_fees = preg_split("/\,/", $request->new_ride_starting_fees[0]);
                $new_ride_waiting_rate = preg_split("/\,/", $request->new_ride_waiting_rate[0]);

                for ($i = 0; $i < count($new_service_id); $i++) {
                    foreach ($arr_service as $service) {
                        if ($service->id == $new_service_id[$i]) {
                            $zone_wise_fareestimation = CountryInformation::create(array('country_id' => $country->id, 'service_id' => $new_service_id[$i], 'fixed_fees' => $new_fixed_fees[$i], 'ride_starting_fees' => $new_ride_starting_fees[$i], 'ride_waiting_rate' => $new_ride_waiting_rate[$i]));
                        }
                    }
                }
                return redirect('admin/countries/list')->with('country-status', 'Country has been created Successfully!');
            }
        }
    }

    /**
     * @description This function is used to get country informations
     * @param Request $request
     * @param $country_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCountryInfo(Request $request, $country_id) {
        $country = Country::find($country_id);
        $arr_to_return = array("error" => 0, "data" => $country);
        return response()->json($arr_to_return);
    }

    /**
     * @description This function is used to update country information
     * @param Request $request
     * @param $country_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function updateCountry(Request $request, $country_id) {
        $country = Country::find($country_id);
        $exitservice_id = array();

        if ($country) {
            $is_new_entry = !($country->hasTranslation());

            $translated_country = $country->translate();
            //$arr_service = ServiceTranslation::get();
            $permit_countryinformation = CountryInformation::where('country_id', $country_id)->get();
            foreach ($permit_countryinformation as $exitservice) {
                $exitservice_id[] = $exitservice->service_id;
            }
            $query = DB::select("SELECT required_pick_up_person FROM " . DB::getTablePrefix() . "services WHERE id NOT IN ( '" . implode("', '", $exitservice_id) . "' )");
            $nonexitserviceinfo = (object) $query;

            if ($request->method() == "GET") {
                $arr_service_category = Category::translatedIn(\App::getLocale())->get();
                $arr_service = Service::translatedIn(\App::getLocale())->get();
                $countryServices = CountryServices::where('country_id', $country_id)->get();

                return view("admin::update-country", array('country_info' => $translated_country, 'main_info' => $country, "categories" => $arr_service_category, "services" => $arr_service, "country_services" => $countryServices, "permit_countryinformation" => $permit_countryinformation, "nonexitserviceinfo" => $nonexitserviceinfo));
            } else {
                // validate and proceed
                $data = $request->all();

                $validate_response = Validator::make($data, array(
                            'name' => 'required|unique:country_translations,name,' . $translated_country->id,
                            'iso' => 'required',
                            'country_code' => 'required',
                            'support_number' => 'required',
                            'currency_code' => 'required',
                            'max_mobile_digit' => 'required',
                            'time_zone' => 'required'
                ));

                if ($validate_response->fails()) {
                    return redirect()->back()->withErrors($validate_response)->withInput();
                } else {
                    $country->iso = $request->iso;
                    $country->country_code = $request->country_code;
                    $country->currency_code = $request->currency_code;
                    $country->cancellation_charge = $request->cancellation_charge;
                    $country->time_zone = $request->time_zone;
                    $country->max_mobile_digit = $request->max_mobile_digit;
                    $country->save();

                    $translated_country->name = $request->name;
                    $translated_country->support_number = $request->support_number;

                    if ($is_new_entry) {
                        $translated_country->country_id = $country_id;
                    }
                    $translated_country->save();
                    return redirect('admin/countries/list')->with('update-country-status', 'Country has been updated successfully!');
                }
            }
        } else {
            return redirect("admin/countries/list");
        }
    }

    /**
     * @description This function is used to update country information according to language
     * @param Request $request
     * @param $country_id
     * @param $locale
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function updateCountryLanguage(Request $request, $country_id, $locale) {
        $country = Country::find($country_id);
        if ($country) {
            $is_new_entry = !($country->hasTranslation($locale));
            $translated_country = $country->translateOrNew($locale);
            if ($request->method() == "GET") {
                return view("admin::update-country-language", array('country_info' => $translated_country));
            } else {
                // validate and proceed
                $data = $request->all();
                $validate_response = Validator::make($data, array(
                            'name' => 'required',
                ));

                if ($validate_response->fails()) {
                    return redirect()->back()->withErrors($validate_response)->withInput();
                } else {
                    $translated_country->name = $request->name;

                    if ($is_new_entry) {
                        $translated_country->country_id = $country_id;
                    }
                    $translated_country->save();
                    return redirect('admin/countries/list')->with('update-country-status', 'Country updated successfully!');
                }
            }
        } else {
            return redirect("admin/countries/list");
        }
    }

    /**
     * @description This function is used to delete country data
     * @param $country_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteCountry($country_id) {
        $country = Country::find($country_id);
        if ($country) {
            $country->delete();

            return redirect('admin/countries/list')->with('country-status', 'Country has been deleted successfully!');
        } else {
            return redirect("admin/countries/list");
        }
    }

    /**
     * @description This function is used to delete the selected country details
     * @param $country_id
     */
    public function deleteCountrySelected($country_id) {
        $country = Country::find($country_id);
        if ($country) {
            $country->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

    /**
     * @description This function is used to show list-states view
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function listStates() {
        return view('admin::list-states');
    }

    /**
     * @description This function is used to return all the states by country
     * @param $country_id
     */
    public function getAllStatesByCountry($country_id) {
        $states = State::where('country_id', $country_id)->translatedIn(\App::getLocale())->get();
        $select_value = '<option value="">Select State</option>';
        if ($country_id != '17') {
            $select_value .= '<option value="32">--ALL--</option>';
        }
        if ($states) {
            foreach ($states as $key => $value) {

                $select_value .= '<option value="' . $value->id . '">' . $value->name . '</option>';
            }
        }
        echo $select_value;
        exit;
    }

    /**
     * @description This function is used to return all the states by coumtry at the time of registration
     * @param $country_id
     */
    public function getAllStatesByCountryRegistration($country_id) {
        $states = State::where('country_id', $country_id)->translatedIn(\App::getLocale())->get();
        $select_value = '<option value="">--' . Lang::choice('website_keywords.region', \App::getLocale()) . '--</option>';
        if ($country_id != '17') {
            if ($states) {
                foreach ($states as $key => $value) {
                    if ($value != '32') {
                        $select_value .= '<option value="' . $value->id . '">' . $value->name . '</option>';
                    }
                }
            }
        }
        echo $select_value;
        exit;
    }

    /**
     * @description This function is used to get all cities by country and state
     * @param $country_id
     * @param $state_id
     */
    public function getAllCitiesByCountryState($country_id, $state_id) {
        $cities = City::where('country_id', $country_id)->where('state_id', $state_id)->translatedIn(\App::getLocale())->get();
        $select_value = '<option value="">--Select--</option>';
        if ($state_id == '32') {
            $select_value .= '<option value="22">--ALL--</option>';
        } else {
            $select_value .= '<option value="22">--ALL--</option>';
            if ($cities) {
                foreach ($cities as $key => $value) {

                    $select_value .= '<option value="' . $value->id . '">' . $value->name . '</option>';
                }
            }
        }
        echo $select_value;
        exit;
    }

    /**
     * @description This function is used to get all cities by country, state for driver
     * @param $country_id
     * @param $state_id
     */
    public function getAllCitiesByCountryStateDriver($country_id, $state_id) {
        $cities = City::where('country_id', $country_id)->where('state_id', $state_id)->translatedIn(\App::getLocale())->get();
        $select_value = '<option value="">--Select--</option>';
        if ($state_id == '32') {
            $select_value .= '<option value="22">--ALL--</option>';
        } else {
            if ($cities) {
                foreach ($cities as $key => $value) {

                    $select_value .= '<option value="' . $value->id . '">' . $value->name . '</option>';
                }
            }
        }
        echo $select_value;
        exit;
    }

    /**
     * @description This function is used to get all cities by country,state for registration
     * @param $country_id
     * @param $state_id
     */
    public function getAllCitiesByCountryStateRegistration($country_id, $state_id) {
        $cities = City::where('country_id', $country_id)->where('state_id', $state_id)->translatedIn(\App::getLocale())->get();
        $select_value = '<option value="">--' . Lang::choice('website_keywords.City', \App::getLocale()) . '--</option>';
        if ($state_id != '32') {
            if ($cities) {
                foreach ($cities as $key => $value) {
                    if ($value != '22') {
                        $select_value .= '<option value="' . $value->id . '">' . $value->name . '</option>';
                    }
                }
            }
            echo $select_value;
            exit;
        }
    }

    /**
     * @description This function is used to return list of state data
     * @param Request $request
     * @return mixed
     */
    public function listStatesData(Request $request) {

        //$all_states = State::translatedIn(\App::getLocale())->get();
        /*if (Auth::user()->userInformation->user_type == '1') {
            $userAddress = UserAddress::where('user_id', Auth::user()->id)->first();
            $country = 0;
            if (isset($userAddress->user_country) && $userAddress->user_country != 17) {
                $country = $userAddress->user_country;
                $all_states = $all_states->reject(function ($state) use ($country) {
                    return ($state->country_id != $country);
                });
            }
        }*/
        /*$search_value = $request->search_value;*/
        /*if ($search_value != "" && $filter_type != "") {
            if ($filter_type == 'region') {
                $all_states = $all_states->reject(function ($state) use ($search_value) {


                    $state_text = strstr(strtoupper($state->name), strtoupper($search_value));


                    if ($state_text == '' || $state_text == '0') {
                        return $state;
                    }
                });
            } else if ($filter_type == 'country') {
                $all_states = $all_states->reject(function ($state) use ($search_value) {


                    $state_text = strstr(strtoupper($state->country->name), strtoupper($search_value));


                    if ($state_text == '' || $state_text == '0') {
                        return $state;
                    }
                });
            }
        }*/
        $filter_type = $request->order_filter_by;
        $all_status = State::query();
        if(isset($filter_type) && $filter_type != '')
        {
            $all_status = $all_status->where('status',$filter_type);
        }
        $all_states = $all_status->get();
        return Datatables::of($all_states)
            ->addColumn('Language', function ($state) {
                $language = '<div class="td_content"><div class="custom_select"><select onchange="selectStateLang(this)" data-placeholder="Choose a Language...">';
                $language .= '<option value="" disabled selected>Select Language</option>';
                if (count(config("translatable.locales_to_display"))) {
                    foreach (config("translatable.locales_to_display") as $locale => $locale_full_name) {
                        if ($locale != 'en') {
                            $language .= '<option id="' . $state->id . '" value="' . $locale . '">' . $locale_full_name . '</option>';
                        }
                    }
                }
                return $language;
            })
            ->addColumn("created_at", function ($state) {
                $date = Carbon::createFromTimeStamp(strtotime($state->created_at))->format('m-d-Y H:i A');
                return $date;
            })
            ->addColumn("updated_at", function ($state) {
                $date = Carbon::createFromTimeStamp(strtotime($state->updated_at))->format('m-d-Y H:i A');
                return $date;
            })
            ->addColumn('country', function ($state) {
                return $state->country->translate()->name;
            })
            ->addColumn('status', function ($state) {
                if($state->status == '0')
                {
                    return 'Inactive';
                }
                else
                {
                    return 'Active';
                }

            })
            ->make(true);
    }

    /**
     * @description This function is used to create new state
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|View
     */
    public function createState(Request $request) {
        if ($request->method() == "GET") {
            $all_countries = Country::translatedIn(\App::getLocale())->where('status','1')->get();
            return view("admin::create-state", array('countries' => $all_countries));
        } else {
            // validate and proceed
            $data = $request->all();
            $validate_response = Validator::make($data, array(
                        'name' => 'required|unique:state_translations,name',
                        'country' => 'required|numeric',
                        'status' => 'required',
            ));

            if ($validate_response->fails()) {
                return redirect()->back()->withErrors($validate_response)->withInput();
            } else {
                $state = State::create(['country_id' => $request->country,'status' => $request->status]);
                $en_state = $state->translateOrNew(\App::getLocale());
                $en_state->name = $request->name;
                $en_state->state_id = $state->id;
                $en_state->save();

                return redirect('admin/states/list')->with('state-status', 'State Created Successfully!');
            }
        }
    }

    /**
     * @description This function is used to update state information
     * @param Request $request
     * @param $state_id
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function updateState(Request $request, $state_id) {
        $state = State::find($state_id);
        if ($state) {
            $is_new_entry = !($state->hasTranslation());
            $translated_state = $state->translate();
            if ($request->method() == "GET") {
                $all_countries = Country::translatedIn(\App::getLocale())->where('status','1')->get();
                return view("admin::update-state", array('state_info' => $translated_state, 'state' => $state, 'countries' => $all_countries));
            } else {
                // validate and proceed
                $data = $request->all();
                $validate_response = Validator::make($data, array(
                            'name' => 'required|unique:state_translations,name,' . $translated_state->id,
                            'country' => 'required|numeric'
                ));

                if ($validate_response->fails()) {
                    return redirect()->back()->withErrors($validate_response)->withInput();
                } else {
                    $translated_state->name = $request->name;
                    $state->country_id = $request->country;
                    $state->status = $request->status;

                    if ($is_new_entry) {
                        $translated_state->state_id = $state_id;
                    }

                    $translated_state->save();
                    $state->save();
                    return redirect('admin/states/list')->with('update-state-status', 'State has been updated Successfully!');
                }
            }
        } else {
            return redirect("admin/states/list");
        }
    }

    /**
     * @description This function is used to update state information by language
     * @param Request $request
     * @param $state_id
     * @param $locale
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function updateStateLanguage(Request $request, $state_id, $locale) {
        $state = State::find($state_id);
        if ($state) {
            $is_new_entry = !($state->hasTranslation($locale));

            $translated_state = $state->translateOrNew($locale);

            if ($request->method() == "GET") {
                return view("admin::update-state-language", array('state_info' => $translated_state));
            } else {
                // validate and proceed
                $data = $request->all();

                $validate_response = Validator::make($data, array(
                            'name' => 'required',
                ));

                if ($validate_response->fails()) {
                    return redirect()->back()->withErrors($validate_response)->withInput();
                } else {
                    $translated_state->name = $request->name;
                    if ($is_new_entry) {
                        $translated_state->state_id = $state_id;
                    }
                    $translated_state->save();
                    return redirect('admin/states/list')->with('update-state-status', 'State has been updated Successfully!');
                }
            }
        } else {
            return redirect("admin/states/list");
        }
    }

    /**
     * @description This function is used to delete the particular state data
     * @param $state_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteState($state_id) {
        $state = State::find($state_id);
        if ($state) {
            $state->delete();
            return redirect('admin/states/list')->with('state-status', 'State deleted successfully!');
        } else {
            return redirect('admin/states/list');
        }
    }

    /**
     * @description This function is used to the selected state information
     * @param $state_id
     */
    public function deleteStateSelected($state_id) {
        $state = State::find($state_id);
        if ($state) {
            $state->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {

            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

    /**
     * @description This function is used to show the list-cities
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function listCities() {
        return view('admin::list-cities');
    }

    /**
     * @description This function is used to return the cities data
     * @param Request $request
     * @return mixed
     */
    public function listCitiesData(Request $request) {
        /*$all_cities = City::translatedIn(\App::getLocale())->get();
        if (Auth::user()->userInformation->user_type == '1') {
            $userAddress = UserAddress::where('user_id', Auth::user()->id)->first();
            $country = 0;
            if (isset($userAddress->user_country) && $userAddress->user_country != 17) {
                $country = $userAddress->user_country;
                $all_cities = $all_cities->reject(function ($city) use ($country) {
                    return ($city->country_id != $country);
                });
            }
        }*/

        /*if ($search_value != "" && $filter_type != "") {
            if ($filter_type == 'city') {
                $all_cities = $all_cities->reject(function ($city) use ($search_value) {
                    $state_text = strstr(strtoupper($city->name), strtoupper($search_value));
                    if ($state_text == '' || $state_text == '0') {
                        return $city;
                    }
                });
            } else if ($filter_type == 'region') {
                $all_cities = $all_cities->reject(function ($city) use ($search_value) {
                    $state_text = strstr(strtoupper($city->state->name), strtoupper($search_value));
                    if ($state_text == '' || $state_text == '0') {
                        return $city;
                    }
                });
            } else if ($filter_type == 'country') {
                $all_cities = $all_cities->reject(function ($city) use ($search_value) {
                    $state_text = strstr(strtoupper($city->country->name), strtoupper($search_value));
                    if ($state_text == '' || $state_text == '0') {
                        return $city;
                    }
                });
            }
        }*/
        $filter_type = $request->order_filter_by;
        $all_cities = City::query();
        if(isset($filter_type) && $filter_type != '')
        {
            $all_cities = $all_cities->where('status',$filter_type);
        }
        $all_cities = $all_cities->translatedIn(\App::getLocale())->get();

        return Datatables::of($all_cities)
            ->addColumn('Language', function ($state) {
                $language = '<div class="td_content"><div class="custom_select"><select onchange="selectCityLang(this)" data-placeholder="Choose a Language...">';
                $language .= '<option value="" disabled selected>Select Language</option>';
                if (count(config("translatable.locales_to_display"))) {
                    foreach (config("translatable.locales_to_display") as $locale => $locale_full_name) {
                        if ($locale != 'en') {
                            $language .= '<option id="' . $state->id . '" value="' . $locale . '">' . $locale_full_name . '</option>';
                        }
                    }
                }
                return $language;
            })
            ->addColumn("created_at", function ($state) {
                $date = Carbon::createFromTimeStamp(strtotime($state->created_at))->format('m-d-Y H:i A');
                return $date;
            })
            ->addColumn("updated_at", function ($state) {
                $date = Carbon::createFromTimeStamp(strtotime($state->updated_at))->format('m-d-Y H:i A');
                return $date;
            })
                ->addColumn('country', function ($city) {
                            return $city->country->translate()->name;
                        })
                        ->addColumn('state', function ($cities) {
                            return $cities->state->translate()->name;
                        })
            ->addColumn('status', function ($cities) {
                if($cities->status == '1')
                {
                    return 'Active';
                }
                else
                {
                    return 'Inactive';
                }
            })
                        ->make(true);
    }

    /**
     * @description This function is used to create the new city details
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|View
     */
    public function createCity(Request $request) {
        if ($request->method() == "GET") {
            $countries = Country::translatedIn(\App::getLocale())->get();
            $countries = $countries->reject(function ($country) {
                return ($country == '17');
            });
            $all_states = State::translatedIn(\App::getLocale())->get();
            return view("admin::create-cities", array('states' => $all_states, "countries" => $countries));
        } else {
            // validate and proceed
            $data = $request->all();
            $validate_response = Validator::make($data, array(
                        'name' => 'required',
                        'state' => 'required|numeric',
                        'country' => 'required|numeric',
                        'status' => 'required'
            ));

            if ($validate_response->fails()) {
                return redirect()->back()->withErrors($validate_response)->withInput();
            } else {

                $city = City::create(['state_id' => $request->state, "country_id" => $request->country, 'status' => $request->status]);

                $en_city = $city->translateOrNew(\App::getLocale());
                $en_city->name = $request->name;
                $en_city->city_id = $city->id;
                $en_city->save();

                return redirect('admin/cities/list')->with('city-status', 'City has been created Successfully!');
            }
        }
    }

    /**
     * @description This function is used to update the city details
     * @param Request $request
     * @param $city_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function updateCity(Request $request, $city_id) {
        $city = City::find($city_id);
        $city_values = City::where('id', $city_id)->first();
        $country_id = 0;
        if ($city_values) {
            $country_id = $city_values->country_id;
        }
        if ($city) {
            $is_new_entry = !($city->hasTranslation());

            $translated_city = $city->translate();

            if ($request->method() == "GET") {
                $countries = Country::translatedIn(\App::getLocale())->get();
                $states_info = State::where('country_id', $country_id)->translatedIn(\App::getLocale())->get();
                /*$arr_service = Service::translatedIn(\App::getLocale())->get();
                $countryServices = CountryServices::where('city_id', $city_id)->get();
                $arr_service_category = Category::translatedIn(\App::getLocale())->get();*/
                return view("admin::update-city", array('city_info' => $translated_city, 'city' => $city, 'states' => $states_info, 'countries' => $countries));
            } else {
                // validate and proceed
                $data = $request->all();
                $validate_response = Validator::make($data, array(
                            'name' => 'required',
                            'state' => 'required',
                            'country' => 'required',
                            'status' => 'required'
                            /*'support_number' => 'required',*/
                ));

                if ($validate_response->fails()) {
                    return redirect()->back()->withErrors($validate_response)->withInput();
                } else {
                    $translated_city->name = $request->name;
                    $city->state_id = $request->state;
                    $city->country_id = $request->country;
                    $city->status = $request->status;
                    $city->support_number = $request->support_number;
                    $translated_city->save();
                    $city->save();

                    /*$country_id = $request->country;
                    CountryServices::where('city_id', $city_id)->delete();
                    if (isset($data['services']) && !empty($data['services'])) {

                        for ($i = 0; $i < count($data['services']); $i++) {
                            $arr_countryServices = array();
                            $arr_countryServices["service_id"] = $data['services'][$i];
                            if (isset($data['price_type_' . $data['services'][$i]])) {
                                $arr_countryServices["price_type"] = $data['price_type_' . $data['services'][$i]];
                            }
                            if (isset($data['base_price_' . $data['services'][$i]]) && !empty($data['base_price_' . $data['services'][$i]])) {
                                $arr_countryServices["base_price"] = $data['base_price_' . $data['services'][$i]];
                            }
                            if (isset($data['price_per_km_' . $data['services'][$i]]) && !empty($data['price_per_km_' . $data['services'][$i]])) {
                                $arr_countryServices["price_per_km"] = $data['price_per_km_' . $data['services'][$i]];
                            }
                            if (isset($data['price_per_min_' . $data['services'][$i]]) && !empty($data['price_per_min_' . $data['services'][$i]])) {
                                $arr_countryServices["price_per_min"] = $data['price_per_min_' . $data['services'][$i]];
                            }
                            if (isset($data['sort_index_' . $data['services'][$i]]) && !empty($data['sort_index_' . $data['services'][$i]])) {
                                $arr_countryServices["sort_index"] = $data['sort_index_' . $data['services'][$i]];
                            }
                            if (isset($data['sort_index_arabic_' . $data['services'][$i]]) && !empty($data['sort_index_arabic_' . $data['services'][$i]])) {
                                $arr_countryServices["sort_index_arabic"] = $data['sort_index_arabic_' . $data['services'][$i]];
                            }
                            if (isset($data['check_point_distance_' . $data['services'][$i]]) && !empty($data['check_point_distance_' . $data['services'][$i]])) {
                                $arr_countryServices["check_point_distance"] = $data['check_point_distance_' . $data['services'][$i]];
                            }
                            if (isset($data['flat_price_' . $data['services'][$i]]) && !empty($data['flat_price_' . $data['services'][$i]])) {
                                $arr_countryServices["flat_price"] = $data['flat_price_' . $data['services'][$i]];
                            }
                            if (isset($data['base_km_' . $data['services'][$i]]) && !empty($data['base_km_' . $data['services'][$i]])) {
                                $arr_countryServices["base_km"] = $data['base_km_' . $data['services'][$i]];
                            }
                            if (isset($data['night_percentage_' . $data['services'][$i]]) && !empty($data['night_percentage_' . $data['services'][$i]])) {
                                $arr_countryServices["night_percentage"] = $data['night_percentage_' . $data['services'][$i]];
                            }
                            if (isset($data['night_time_from_' . $data['services'][$i]]) && !empty($data['night_time_from_' . $data['services'][$i]])) {
                                $arr_countryServices["night_time_from"] = $data['night_time_from_' . $data['services'][$i]];
                            }
                            if (isset($data['night_time_to_' . $data['services'][$i]]) && !empty($data['night_time_to_' . $data['services'][$i]])) {
                                $arr_countryServices["night_time_to"] = $data['night_time_to_' . $data['services'][$i]];
                            }
                            $arr_countryServices["country_id"] = $country_id;
                            $arr_countryServices["city_id"] = $city_id;
                            CountryServices::create($arr_countryServices);
                        }
                    }*/
                    /* save country services */
                    return redirect("admin/cities/list")->with('update-city-status', 'City updated successfully!');
                }
            }
        } else {
            return redirect("admin/cities/list");
        }
    }

    /**
     * @description This function is used to update the city
     * @param Request $request
     * @param $city_id
     * @param $locale
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function updateCityLanguage(Request $request, $city_id, $locale) {
        $city = City::find($city_id);

        if ($city) {
            $is_new_entry = !($city->hasTranslation($locale));

            $translated_city = $city->translateOrNew($locale);

            if ($request->method() == "GET") {
                return view("admin::update-city-language", array('city_info' => $translated_city));
            } else {
                // validate and proceed
                $data = $request->all();

                $validate_response = Validator::make($data, array(
                            'name' => 'required',
                ));

                if ($validate_response->fails()) {
                    return redirect()->back()->withErrors($validate_response)->withInput();
                } else {
                    $translated_city->name = $request->name;

                    if ($is_new_entry) {
                        $translated_city->city_id = $city_id;
                    }

                    $translated_city->save();
                    return redirect("admin/cities/list")->with('update-city-status', 'City updated successfully!');
                }
            }
        } else {
            return redirect("admin/cities/list");
        }
    }

    /**
     * @description This function is used to delete the particular city
     * @param $city_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteCity($city_id) {
        $city = City::find($city_id);

        if ($city) {
            $city->delete();
            return redirect('admin/cities/list')->with('city-status', 'City has been deleted successfully!');
        } else {
            return redirect('admin/cities/list');
        }
    }

    /**
     * @description This function is used to delete the selected city
     * @param $city_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteCitySelected($city_id) {
        $city = City::find($city_id);
        if ($city) {
            $city->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

    /**
     * @description This function is used to generate random number
     * @return string
     */
    private function generateReferenceNumber() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
    }

    /**
     * @description This function is used to delete the selected driver user
     * @param $user_id
     */
    public function deletSelectedDriverUser($user_id) {
        $user = User::find($user_id);
        if ($user) {
            $check_driver_active_orders = Order::where('driver_id', $user_id)->whereIn('status', array('0', '1'))->get();
            if (count($check_driver_active_orders) == 0) {
                $user->delete();
                echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
                exit();
            } else {
                echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
                exit();
            }
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
            exit();
        }
    }

    /**
     * @description This function is used to show driver listing
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function listDriverUsers() {

        $all_countries = Country::translatedIn(\App::getLocale())->get();
        $pending_amit = DriverPendingAmount::where('status', 0)->sum('amount');
        return view("admin::list-driver-users", array("all_countries" => $all_countries, "total_pending_amount" => $pending_amit));
    }

    /**
     * @description This function is used to show the driver information on listing
     * @param Request $request
     * @return mixed
     */
    public function listDriverUsersData(Request $request) {
        $country_name = $request->country_name;
        $filter_by_week = $request->week_filter;
        $order_filter_by = $request->order_filter_by;
        $order_country_id = $request->order_country;
        $order_drivert_date = $request->drivert_date;
        $order_end_date = $request->end_date;
        $driver_users = UserInformation::select('user_informations.user_id', 'user_informations.user_type', 'user_informations.first_name', 'user_informations.last_name', 'users.email', 'user_informations.mobile_code', 'user_informations.user_mobile', 'user_informations.user_status', 'user_informations.platform','user_informations.added_by', 'users.created_at','user_addresses.user_city');
        $driver_users->leftJoin('users', function ($join) {
            $join->on('user_informations.user_id', '=', 'users.id');
        });
        $driver_users->leftJoin('user_addresses', function ($join) {
            $join->on('user_informations.user_id', '=', 'user_addresses.user_id');
        });
        if(Auth::user()->userInformation->user_type == '1')
        {
            $driver_users->where(['user_informations.user_type' => '4']);

        }
        else
        {
            $driver_users->where(['user_informations.user_type' => '4'])->where(['user_informations.added_by' => Auth::user()->id]);

        }
        $driver_users = $driver_users->orderby('users.id', 'DESC')->get();
        $i = 0;
        foreach ($driver_users as $driver) {
            $city_name = 'N/A';
            if(isset($driver->user_city))
            {
                $city = CityTranslation::where('city_id',$driver->user_city)->first(['name']);
                if($city)
                {
                    $city_name = $city->name;
                }
                else
                {
                    $city_name = 'N/A';
                }
            }
            $driver_users[$i]['email'] = isset($driver->email)?$driver->email:'N/A';
            $driver_users[$i]['full_name'] = $driver->first_name . ' ' . $driver->last_name;

            $driver_users[$i]['user_mobile'] = "+" . str_replace("+", "", $driver->mobile_code) . " " . $driver->user_mobile;
            $location = '';
            if ($driver->mobile_code == "91") {
                $location = "India";
            }
            if ($driver->mobile_code == "965") {
                $location = "Kuwait";
            }
            $driver_users[$i]['location'] = $city_name;
            $type = '';
            if($driver->added_by_detail->user_type == '1')
            {
                $type = '(Admin)';
            }
            else
            {
                $type = '(Agent)';
            }
            $driver_users[$i]['created_by'] = $driver->added_by_detail->first_name .' '. $driver->added_by_detail->last_name .' '.$type;
            if ($driver->platform == '0') {
                $driver_users[$i]['device'] = "Android";
            } else if ($driver->platform == '1') {
                $driver_users[$i]['device'] = "IOS";
            } else {
                $driver_users[$i]['device'] = "Web";
            }
            $date = Carbon::createFromTimeStamp(strtotime($driver->created_at))->format('m-d-Y H:i A');
            $driver_users[$i]['posted_date'] = $date;

            $avg_rating = 0;
            $query = DB::select("SELECT AVG(rating) AS avg_rating FROM " . DB::getTablePrefix() . "user_rating_informations WHERE  `to_id`= " . $driver->user_id . " AND `status` = '1'");
            if (isset($query) && count($query) > 0) {
                $avg_rating = number_format($query[0]->avg_rating, 1, '.', '');
            }
            $driver_users[$i]['rating'] = $avg_rating;

            $i++;
        }
        if ($filter_by_week != "") {
            $driver_users = $driver_users->filter(function ($user) {
                if (isset($user->user)) {
                    $today_date = date("Y-m-d");
                    $seven_days_back = date('Y-m-d', strtotime('-7 days'));
                    return date("Y-m-d", strtotime($user->user->created_at)) <= $today_date && date("Y-m-d", strtotime($user->user->created_at)) >= $seven_days_back;
                }
            });
        }
        if ($order_country_id != "") {
            if ($order_country_id != "17") {
                $driver_users = $driver_users->filter(function ($user) use ($order_country_id) {

                    $mobile_code = 0;
                    $mobile_code_with_plus = 0;
                    if (isset($user->mobile_code)) {
                        $mobile_code = $user->mobile_code;
                        $mobile_code = str_replace("+", "", $mobile_code);
                        $mobile_code_with_plus = "+" . $mobile_code;
                    }
                    return ($mobile_code == $order_country_id);
                });
            }
        }
        if ($order_drivert_date != "" && $order_end_date != "") {
            $driver_users = $driver_users->filter(function ($user) use ($order_drivert_date, $order_end_date) {
                return date("Y-m-d", strtotime($user->created_at)) >= $order_drivert_date && date("Y-m-d", strtotime($user->created_at)) <= $order_end_date;
            });
        }
        if ($order_filter_by != "") {
            $driver_users = $driver_users->filter(function ($all_data) use ($order_filter_by, $order_country_id) {
                return ($all_data->user_status == $order_filter_by);
            });
        }
        return Datatables::of($driver_users)
                        ->addColumn('full_name', function ($regsiter_user) {
                            return $regsiter_user->full_name;
                        })
                        ->addColumn('email', function ($admin_users) {
                            return $admin_users->email;
                        })
                        ->addColumn('username', function ($admin_users) {
                            return $admin_users->username;
                        })
                        ->addColumn('user_mobile', function ($admin_users) {
                            return $admin_users->user_mobile;
                        })
                        ->addColumn('pending_amount', function ($admin_users) {
                            $pending_amit = DriverPendingAmount::where(['user_id' => $admin_users->user_id, 'status' => 0])->sum('amount');
                            return $pending_amit;
                        })
                        ->addColumn('location', function ($admin_users) {
                            return $admin_users->location;
                        })
                        ->addColumn('status', function ($admin_users) {

                            $html = '';
                            if ($admin_users->user_status == 0) {
                                $html = '<div  id="active_div' . $admin_users->user->id . '"    style="display:none;"  >
                                                <a class="btn btn-active" title="Click to Change changeStarUserStatus" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 2);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Active</a> </div>';
                                $html = $html . '<div id="inactive_div' . $admin_users->user->id . '"  style="display:inline-block" ><a class="btn btn-inactive" title="Click to Change Status" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 1);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Inactive </a> </div>';
                                $html = $html . '<div id="blocked_div' . $admin_users->user->id . '" style="display:none;"><a class="btn btn-inactive" title="Click to Change Status" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 1);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Blocked </a> </div>';
                            } else if ($admin_users->user_status == 2) {
                                $html = '<div  id="active_div' . $admin_users->user->id . '"  style="display:none;" ><a class="btn btn-active title="Click to Change Status" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 2);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Active</a> </div>';
                                $html = $html . '<div id="blocked_div' . $admin_users->user->id . '"    style="display:inline-block" ><a class="btn btn-inactive" title="Click to Change Status" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 1);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Blocked</a> </div>';
                            } else if ($admin_users->user_status == 3) {
                                $html = '<div  id="active_div' . $admin_users->user->id . '"  style="display:none;" ><a class="btn btn-active title="Click to Change Status" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 2);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Active</a> </div>';
                                $html = $html . '<div id="blocked_div' . $admin_users->user->id . '"    style="display:none" ><a class="btn btn-inactive" title="Click to Change Status" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 1);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Blocked</a> </div>';
                                $html = $html . '<div id="suspended_div' . $admin_users->user->id . '"    style="display:inline-block" ><a class="btn btn-suspended" title="Click to Change Status" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 1);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Suspended</a> </div>';
                            } else {
                                $html = '<div  id="active_div' . $admin_users->user->id . '"   style="display:inline-block" ><a class="btn btn-active" title="Click to Change Status" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 2);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Active</a> </div>';
                                $html = $html . '<div id="blocked_div' . $admin_users->user->id . '"  style="display:none;"><a class="btn btn-inactive" title="Click to Change Status" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 1);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Blocked</a> </div>';
                            }
                            return $html;
                        })
                        ->addColumn('document_status', function ($regsiter_user) {
                            $driver_user_details = DriverDocument::where('is_mandetory', '=', '1')->get();
                            $id = array();
                            foreach ($driver_user_details as $driver_doc) {
                                $id[] = $driver_doc->id;
                            }


                            $exit_doc = DriverDocumentInformation::where('user_id', '=', $regsiter_user->user->id)->get();
                            $inactive_driver_status = DriverDocumentInformation::where('user_id', '=', $regsiter_user->user->id)->whereIn('status', ['0','2','3'])->get();

                            $document_id = array();
                            foreach ($exit_doc as $exit) {
                                if (isset($exit->document_id) && !empty($exit->document_id)) {
                                    $document_id[] = $exit->document_id;
                                }
                            }
                            $difference = array_diff($id, $document_id);
                            $html = '';
                            $html .= '<div id="active_div_back' . $regsiter_user->user->id . '"  class="td_content text-center">';
                            $html .= '<div class="is_blocked">';
                            $html .= '<button disabled rel="' . $regsiter_user->user->id . '" id="reg-user-' . $regsiter_user->user->id . '" onclick="changeDocumentStatus(this)" type="button"';
                            if (count($difference) > 0) {
                                $html .= ' class="btn btn-toggle" aria-pressed="false"';
                            } else {
                                if (count($inactive_driver_status) > 0) {
                                    $html .= ' class="btn btn-toggle" aria-pressed="false"';
                                } else {
                                    $html .= ' class="btn btn-toggle active" aria-pressed="true"';
                                }
                            }
                            $html .= ' data-toggle="button" autocomplete="off">';
                            $html .= '<div class="handle"></div></button></div></div>';
                            return $html;
                        })
                        ->addColumn('available', function ($admin_users) {
                            return (isset($admin_users->user->driverUserInformation->availability) && ($admin_users->user->driverUserInformation->availability == 1) ? 'Yes' : 'No');
                        })
                        ->addColumn('having_active_order', function ($admin_users) {
                            $current_order = "No";
                            $orderCount = Order::where('driver_id', $admin_users->user_id)->where('status', '1')->first();
                            if (isset($orderCount)) {
                                $current_order = "Yes";
                            }
                            return $current_order;
                        })
                        ->addColumn('posted_date', function ($admin_users) {
                            return $admin_users->posted_date;
                        })
                        ->addColumn('device', function ($admin_users) {
                            return $admin_users->device;
                        })
                        ->addColumn('rating', function ($regsiter_user) {
                             

                             if ($regsiter_user->user_status == 0) {
                                return "N/A";
                             }

                            return $regsiter_user->rating;
                        })
                        ->make(true);
    }

    /**
     * @description This function is used to create the driver user
     * @param Request $request
     * @param bool $is_admin
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|View
     */
    public function createDriverUser(Request $request, $is_admin = false) {
        if ($request->method() == "GET") {
            $country = 0;
            $state = 0;
            $city = 0;
            if (Auth::user()->userAddress) {

                foreach (Auth::user()->userAddress as $address) {
                    $country = $address->user_country;
                    $state = $address->user_state;
                    $city = $address->user_city;
                }
            }
            $states = array();
            $cities = array();
            
            if ($country != '17') {
                $states = State::where('country_id', $country)->translatedIn(\App::getLocale())->get();

                if ($state != '32') {
                    $cities = City::where('state_id', $state)->translatedIn(\App::getLocale())->get();
                }
            }

            $agent_users = User::where('supervisor_id', Auth::user()->id)->get();
            $allCompanies = array();
            if (Auth::user()->userInformation->user_type == '4') {
                $compnies = UserInformation::where('user_type', '5')->get();
                $allCompanies = $compnies->reject(function ($company) {
                    return ($company->user->supervisor_id != Auth::user()->id);
                });
            }
            if (Auth::user()->userInformation->user_type == '6') {

                $compnies = UserInformation::where('user_type', '5')->get();
                $allAgents = array();
                $agents = User::where('supervisor_id', Auth::user()->id)->get();
                if (count($compnies) > 0) {
                    foreach ($agents as $agent) {
                        $allAgents[] = $agent->id;
                    }
                    $allAgents[] = Auth::user()->id;
                }
                $allCompanies = $compnies->reject(function ($company) use ($allAgents) {
                    return ((!in_array($company->user->supervisor_id, $allAgents)));
                });
            }
            if (Auth::user()->userInformation->user_type == '5') {

                $allCompanies = UserInformation::where('user_id', Auth::user()->id)->get();
            }
            if (Auth::user()->userInformation->user_type == '1') {
                $country = 0;
                $state = 0;
                $city = 0;
                if (Auth::user()->userAddress) {

                    foreach (Auth::user()->userAddress as $address) {
                        $country = $address->user_country;
                        $state = $address->user_state;
                        $city = $address->user_city;
                    }
                }
                $compnies = UserInformation::where('user_type', '5')->get();
                $allCompanies = $compnies->reject(function ($user) use ($country, $state, $city) {
                    $driver_country = 0;
                    $driver_state = 0;
                    $driver_city = 0;
                    if ($user->user->userAddress) {
                        foreach ($user->user->userAddress as $address) {
                            $driver_country = $address->user_country;
                            $driver_state = $address->user_state;
                            $driver_city = $address->user_city;
                        }
                    }
                    $condition = false;
                    $contry_passed = false;
                    $state_passed = false;
                    $city_passed = false;
                    if ($country != '3') {
                        if ($country != '17' && $country != 0) {
                            $contry_passed = ($driver_country != $country);
                        }
                        if ($state != '32' && $state != 0) {
                            $state_passed = ($driver_state != $state);
                        }
                        if ($city != '22' && $city != 0) {
                            $city_passed = ($driver_city != $city);
                        }
                        return ($condition || ($contry_passed || $state_passed || $city_passed));
                    } else {
                        $contry_passed = ($driver_country != $country);
                        if ($state != '5' && $state != 0) {
                            return ($condition || ($contry_passed));
                        } else {
                            return ($condition || ($contry_passed || $state_passed));
                        }
                    }
                });
            }
            if(Auth::user()->userInformation->user_type == '3')
            {
                $hubs = Hub::where(['hub_status' => '1','created_by' => Auth::user()->id])->get();
                $agent_state_id = Auth::user()->userAddress[0]->user_state;
                $all_states = State::select('id')->translatedIn(\App::getLocale())->where('country_id',10)->where('id',$agent_state_id)->get()->toArray();
            }
            else
            {
                $hubs = Hub::where(['hub_status' => '1'])->get();
                $all_states = State::select('id')->translatedIn(\App::getLocale())->where('country_id',10)->get()->toArray();
            }
            $arr_service = Service::translatedIn(\App::getLocale())->get();
            $nationality = Nationality::where('id', '!=', '103')->orderBy('country_name', 'ASC')->get();
            $country = Country::select('id')->translatedIn(\App::getLocale())->where('id','10')->first()->toArray();
            $all_Spokenlangusge = SpokenLanguage::translatedIn(\App::getLocale())->get();
            return view("admin::create-driver-user", array("country" => $country,'all_states' => $all_states, 'hubs'=>$hubs));
        } elseif ($request->method() == "POST") {
            $data = $request->all();
            //dd($data);
            $data['user_mobile'] = substr($data['user_mobile'], 0, 1) == '0' ? ltrim($data['user_mobile'], "0") : $data['user_mobile'];
            $data['user_mobile'] = str_replace(' ', '', $data['user_mobile']);
            $data['user_mobile'] = str_replace(' ', '', $data['user_mobile']);
            $mob_num_len = $data['mobile_code'] == '+91' ? 10 : 8;
            /*$arrUserEmail = User::where("email", $data['email'])->get();
            $arrUserEmail = $arrUserEmail->filter(function ($user) {
                if (isset($user->userInformation)) {
                    return $user->userInformation->user_type == 2;
                }
            });*/
            /*$arrUserMobile = UserInformation::where("user_mobile", $data['user_mobile'])->where('user_type', 2)->first();*/
            /*if (Auth::user()->userInformation->user_type != 4) {
                if (count($arrUserEmail) > 0) {
                    $validate_response = Validator::make($data, array(
                                'email' => 'required|email|max:255|unique:users,email',
                                    )
                    );
                } elseif (count($arrUserMobile) > 0) {
                    $validate_response = Validator::make($data, array(
                                'user_mobile' => 'required|digits:' . $mob_num_len . '|numeric|min:1|unique:user_informations,user_mobile',
                                    )
                    );
                } else {
                    $validate_response = Validator::make($data, array(
                                'first_name' => 'required',
                                'last_name' => 'required',
                                'taxi_type' => 'required',
                                'civil_id' => 'required|min:12|unique:user_informations,civil_id',
                                'nationality' => 'required',
                                'password' => 'required|min:7|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9@$!%*?&]*$/',
                                'password_confirmation' => 'required|min:7|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9@$!%*?&]*$/|same:password'
                                    ), array(
                                "password.regex" => 'Please enter a valid password(allowed special charactors (@$!%*?&))'
                                    )
                    );
                }
            } else {

                if (count($arrUserEmail) > 0) {
                    $validate_response = Validator::make($data, array(
                                'email' => 'required|email|max:255|unique:users,email',
                                    )
                    );
                } elseif (count($arrUserMobile) > 0) {
                    $validate_response = Validator::make($data, array(
                                'user_mobile' => 'required|digits:' . $mob_num_len . '|numeric|min:1|unique:user_informations,user_mobile',
                                    )
                    );
                } else {
                    $validate_response = Validator::make($data, array(
                                'first_name' => 'required',
                                'taxi_type' => 'required',
                                'last_name' => 'required',
                                'nationality' => 'required',
                                'civil_id' => 'required|min:12',
                                'password' => 'required|confirmed|required|min:7|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9@$!%*?&]*$/',
                                'password_confirmation' => 'required|min:7|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9@$!%*?&]*$/:same:password'
                                    ), array(
                                "password.regex" => 'Please enter a valid password(allowed special charactors (@$!%*?&))'
                                    )
                    );
                }
            }*/
            $validate_response = Validator::make($data, array(
                'first_name' => 'required',
                'last_name' => 'required',
                'city' => 'required',
                'state' => 'required',
                'hub_id' => 'required',
                'user_mobile' => 'required|numeric|min:1|unique:user_informations,user_mobile',
                //'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|confirmed|required|min:7|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9@$!%*?&]*$/',
                'password_confirmation' => 'required|min:7|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9@$!%*?&]*$/|same:password'
            ), array(
                    "password.regex" => 'Please enter a valid password(allowed special charactors (@$!%*?&))'
                )
            );
            if ($validate_response->fails()) {
                return redirect()->back()
                                ->withErrors($validate_response)
                                ->withInput();
            } else {

                if ($request->file('logo') != '') {
                    $extension = $request->file('logo')->getClientOriginalExtension();
                    $path = realpath(dirname(__FILE__) . '/../../../../');
                    $new_file_name = time() . "." . $extension;
                    $old_file = $path . '/storage/app/public/user-image/' . $new_file_name;
                    $new_file = $path . '/storage/app/public/user-image/' . $new_file_name;
                    \Storage::put('public/user-image/' . $new_file_name, file_get_contents($request->file('logo')->getRealPath()));
                    $command = "convert " . $old_file . " -resize 300x200^ " . $new_file;
                    exec($command);
                }
                /*$mobile_code = 0;
                if (isset($data["mobile_code"]) ? $data["mobile_code"] : "") {
                    $mobile_code = $data["mobile_code"];
                } else {
                    $mobile_code = isset(Auth::user()->userInformation->mobile_code) ? Auth::user()->userInformation->mobile_code : '0';
                }*/
                /*$userCheck = UserInformation::where('user_mobile', ltrim($data['user_mobile'], 0))->get();
                $userCheck = $userCheck->reject(function ($user_data) use ($mobile_code) {
                    $flag = 0;
                    if (str_replace("+", "", $user_data->mobile_code) != str_replace("+", "", $mobile_code)) {
                        $flag = 1;
                    }
                    return $flag;
                });*/
                /*$agent_id = 0;
                $company_id = 0;
                if (isset($data["agent"])) {
                    $agent_id = $data["agent"];
                }
                if (isset($data["comp_name"])) {
                    $company_id = $data["comp_name"];
                }
                if (Auth::user()->userInformation->user_type == '4') {
                    $agent_id = Auth::user()->id;
                }
                if (Auth::user()->userInformation->user_type == '5') {
                    $userCheckInfo = UserInformation::where('user_type', '4')->where('user_id', Auth::user()->supervisor_id)->first();
                    if (count($userCheckInfo) > 0) {
                        $agent_id = Auth::user()->supervisor_id;
                    }
                }*/

                $created_user = User::create(array(
                            'email' => $data['email'],
                            'password' => $data['password'],
                            'username' => ltrim($data['user_mobile'], 0),
                            'supervisor_id' => Auth::user()->id,
                            //'agent_id_val' => $agent_id,
                            //'company_id' => $company_id,
                ));
                $user_code = $data['user_mobile'] . '-' . $created_user->id;

                // update User Information

                /*
                 * Adjusted user specific columns, which may not passed on front end and adjusted with the default values
                 */
                $data["user_type"] = isset($data["user_type"]) ? $data["user_type"] : "4";    // 1 may have several mean as per enum stored in the database. Here we

                $data["user_status"] = isset($data["user_status"]) ? $data["user_status"] : "0";  // 0 means not active

                $data["gender"] = isset($data["gender"]) ? $data["gender"] : "3";       // 3 means not specified
                //$data["agent_id_val"] = isset($data["agent"]) ? $data["agent"] : "3";       // 3 means not specified

                $new_file_name = isset($new_file_name) ? $new_file_name : "";
                $data["facebook_id"] = isset($data["facebook_id"]) ? $data["facebook_id"] : "";
                $data["twitter_id"] = isset($data["twitter_id"]) ? $data["twitter_id"] : "";
                $data["google_id"] = isset($data["google_id"]) ? $data["google_id"] : "";
                $data["user_birth_date"] = isset($data["user_birth_date"]) ? $data["user_birth_date"] : "";
                $data["first_name"] = isset($data["first_name"]) ? preg_replace('/\s/', '', $data["first_name"]) : "";
                $data["last_name"] = isset($data["last_name"]) ? preg_replace('/\s/', '', $data["last_name"]) : "";
                $data["civil_id"] = isset($data["civil_id"]) ? $data["civil_id"] : "";
                
                $data["about_me"] = isset($data["about_me"]) ? $data["about_me"] : "";
                $data["user_mobile"] = isset($data["user_mobile"]) ? $data["user_mobile"] : "";
                $data["mobile_code"] = isset($data["mobile_code"]) ? $data["mobile_code"] : "";
                $data["owner_number"] = isset($data["owner_number"]) ? $data["owner_number"] : "";
                $data["rejection_limit"] = isset($data["rejection_limit"]) ? $data["rejection_limit"] : "";
                $data["contact_person_name"] = isset($data["contact_person_name"]) ? $data["contact_person_name"] : "";
                $data["contact_person_number"] = isset($data["contact_person_number"]) ? $data["contact_person_number"] : "";
                $data["owner_name"] = isset($data["owner_name"]) ? $data["owner_name"] : "";
                $data["nationality"] = isset($data["nationality"]) ? $data["nationality"] : "";

                $referral_code = $this->generateRandomString($data["first_name"]);
                $arr_userinformation = array();
                $arr_userinformation["profile_picture"] = $new_file_name;
                $arr_userinformation["owner_number"] = $data["owner_number"];
                $arr_userinformation["owner_name"] = $data["owner_name"];
                $arr_userinformation["gender"] = $data["gender"];
                $arr_userinformation["activation_code"] = "";             // By default it'll be no activation code
                $arr_userinformation["facebook_id"] = $data["facebook_id"];
                $arr_userinformation["twitter_id"] = $data["twitter_id"];
                $arr_userinformation["google_id"] = $data["google_id"];
                $arr_userinformation["user_birth_date"] = $data["user_birth_date"];
                $arr_userinformation["first_name"] = $data["first_name"];
                $arr_userinformation["last_name"] = $data["last_name"];
                $arr_userinformation["civil_id"] = $data["civil_id"];
               
                $arr_userinformation["nationality"] = $data["nationality"];
                $arr_userinformation["about_me"] = $data["about_me"];
                $arr_userinformation["rejection_limit"] = $data["rejection_limit"];
                $arr_userinformation["user_mobile"] = $data["user_mobile"];
                $arr_userinformation["user_status"] = $data["user_status"];
                $arr_userinformation["user_type"] = '4';
                $arr_userinformation["user_id"] = $created_user->id;
                $arr_userinformation["user_code"] = $user_code;
                $arr_userinformation["referral_code"] = $referral_code;
                $arr_userinformation["added_by"] = Auth::user()->id;
                $arr_userinformation["mobile_code"] = isset($data["mobile_code"]) ? (str_replace("+", "", $data["mobile_code"])) : '';


                //addding user country state city
                /*if (Auth::user()->userInformation->user_type == 1) {
                    $arr_userAddress["user_country"] = isset($data["country"]) ? $data["country"] : "NULL";
                    $arr_userAddress["user_state"] = isset($data["state"]) ? $data["state"] : "NULL";
                    $arr_userAddress["user_city"] = isset($data["city"]) ? $data["city"] : "NULL";
                    $arr_userinformation["mobile_code"] = isset($data["mobile_code"]) ? (str_replace("+", "", $data["mobile_code"])) : '';
                } else {
                    if (Auth::user()->userAddress) {
                        $country = 0;
                        $state = 0;
                        $city = 0;
                        foreach (Auth::user()->userAddress as $address) {
                            $country = $address->user_country;
                            $state = $address->user_state;
                            $city = $address->user_city;
                        }
                    }
                    $arr_userAddress["user_country"] = $country;
                    $arr_userAddress["user_state"] = $state;
                    $arr_userAddress["user_city"] = $city;
                    $arr_userinformation["mobile_code"] = isset(Auth::user()->userInformation->mobile_code) ? Auth::user()->userInformation->mobile_code : '0';
                }*/



                $updated_user_info = UserInformation::create($arr_userinformation);
                // add contact details
                /*$arr_userContactInformation = new UserEmergencyContactInformation();
                $arr_userContactInformation["user_id"] = $created_user->id;
                $arr_userContactInformation["person_name"] = $data["contact_person_name"];
                $arr_userContactInformation["mobile_no"] = $data["contact_person_number"];
                $arr_userContactInformation["mobile_code"] = isset($data["mobile_code"]) ? (str_replace("+", "", $data["mobile_code"])) : '';
                $arr_userContactInformation["status"] = '1';
                $arr_userContactInformation->save();*/

                /*if (isset($data['taxi_type'])) {
                    $arr_services = new UserServiceInformation();
                    $arr_services->user_id = $created_user->id;
                    $arr_services->service_id = $data['taxi_type'];
                    $arr_services->save();
                }*/
                $arr_userAddress["user_country"] = isset($data["country"]) ? $data["country"] : "NULL";
                $arr_userAddress["user_state"] = isset($data["state"]) ? $data["state"] : "NULL";
                $arr_userAddress["user_city"] = isset($data["city"]) ? $data["city"] : "NULL";
                $arr_userAddress["user_id"] = $created_user->id;
                UserAddress::create($arr_userAddress);

                /*$userRole = Role::where("slug", "registered.user")->first();
                $created_user->attachRole($userRole);
                $created_user->save();*/
                $arr_driver_userinformation = array();
                $arr_driver_userinformation['user_id'] = $created_user->id;
                $arr_driver_userinformation['hub_id'] = $data["hub_id"];
                $updated_driver_user_info = DriverUserInformation::create($arr_driver_userinformation);
                
                $driver_rating_arr = [];
                $driver_rating_arr['to_id'] = $created_user->id;
                $driver_rating_arr['from_id'] = 0;
                $driver_rating_arr['rating'] = 5.00;
                $driver_rating_arr['status'] = '1';
                $insert_rating = UserRatingInformation::create($driver_rating_arr);


                /*$updated_driver_user_info->save();*/
                if ($data['email'] != '') {
                    $site_email = GlobalValues::get('site-email');
                    $site_title = GlobalValues::get('site-title');
                    $arr_keyword_values = array();
                    $email_template_key = "driver-registration-successfull-en";
                    $template = EmailTemplate::where("template_key", $email_template_key)->first();
                    $activation_code = $this->generateReferenceNumber();
                    //Assign values to all macros
                    $arr_keyword_values['FIRST_NAME'] = $updated_user_info->first_name;
                    $arr_keyword_values['LAST_NAME'] = $updated_user_info->last_name;
                    $arr_keyword_values['PASSWORD'] = $data["password"];
                    $arr_keyword_values['EMAIL'] = $data["email"];
                    $arr_keyword_values['USER_NAME'] = $data['email'];
                    $arr_keyword_values['RESET_LINK'] = url('verify-user-email/' . $activation_code);
                    $arr_keyword_values['SITE_TITLE'] = $site_title;
                    $site_url = GlobalValues::get('site-url');
                    $facebook_url = GlobalValues::get('facebook-link');
                    $instagram_url = GlobalValues::get('instagram-link');
                    $youtube_url = GlobalValues::get('youtube-link');
                    $twitter_url = GlobalValues::get('twitter-link');
                    $arr_keyword_values['SITE_URL'] = $site_url;
                    $arr_keyword_values['FACEBOOK_URL'] = $facebook_url;
                    $arr_keyword_values['INSTAGRAM_URL'] = $instagram_url;
                    $arr_keyword_values['YOUTUBE_URL'] = $youtube_url;
                    $arr_keyword_values['TWITTER_URL'] = $twitter_url;
                    // updating activation code
                    $updated_user_info->activation_code = $activation_code;
                    $updated_user_info->save();
                    $tempate_name = "emailtemplate::driver-registration-successfull-en";
                    if(isset($created_user) && $created_user->email != ""){
                        // oommented due to smpt detail delay
                       /* @Mail::send($tempate_name, $arr_keyword_values, function ($message) use ($created_user, $site_email, $site_title, $template) {
                            $message->to($created_user->email)->subject($template->subject)->from($site_email, $site_title);
                        });*/
                    }
                }
                if(Auth::user()->userInformation->user_type == '1')
                {
                    return redirect('admin/update-driver-user/' . $created_user->id)->with("create-user-status", "Driver user has been created successfully");
                }
                else
                {
                    return redirect('agent/update-driver-user/' . $created_user->id)->with("create-user-status", "Driver user has been created successfully");
                }
            }
        }
    }

    /**
     * @description This function is used to update driver vehicle information
     * @param Request $request
     * @param $user_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updateDriverUserVehicle(Request $request, $user_id) {
        $data = $request->all();
        if ($data['type'] == '0') {
            $validate_response = Validator::make($data, array(
                        'vehicle_name' => 'required',
                        'vehicle_color' => 'required',
                        'plate_number' => 'required',
                            ), array(
                        'vehicle_name.required' => 'Please select car model',
                        'vehicle_color.required' => 'Please select car color',
            ));
        } else {
            $validate_response = Validator::make($data, array(
                        'vehicle_list' => 'required'
                            ), array(
                        'vehicle_list.required' => 'Please select a vehicle',
            ));
        }
        if ($validate_response->fails()) {

            return redirect($request->url())->withErrors($validate_response)->withInput();
        } else {

            if ($data['type'] == '0') {
                $arrVehicleInformationData = array();
                if ($request->hasFile('vehicle_image')) {
                    $uploaded_file = $request->file('vehicle_image');
                    $extension = $uploaded_file->getClientOriginalExtension();
                    $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
                    $path = realpath(dirname(__FILE__) . '/../../../../');
                    $old_file = $path . '/storage/app/public/vehicle-images/' . $new_file_name;
                    $new_file = $path . '/storage/app/public/vehicle-images/' . $new_file_name;
                    file_put_contents($path . '/storage/app/public/vehicle-images/' . '/' . $new_file_name, file_get_contents($request->file('vehicle_image')->getRealPath()));
                    $command = "convert " . $old_file . " -resize 300x200^ " . $new_file;
                    exec($command);
                    $arrVehicleInformationData['vehicle_image'] = $new_file_name;
                }
                if ($request->hasFile('plate_number_image')) {

                    $uploaded_file = $request->file('plate_number_image');
                    $extension = $uploaded_file->getClientOriginalExtension();
                    $new_file_name1 = str_replace(".", "-", microtime(true)) . "." . $extension;
                    $path = realpath(dirname(__FILE__) . '/../../../../');
                    $old_file1 = $path . '/storage/app/public/vehicle-number-images/' . $new_file_name1;
                    $new_file1 = $path . '/storage/app/public/vehicle-number-images/' . $new_file_name1;
                    Storage::put('public/vehicle-number-images/' . $new_file_name1, file_get_contents($request->file('plate_number_image')->getRealPath()));
                    $command = "convert " . $old_file1 . " -resize 300x200^ " . $new_file1;
                    exec($command);
                    $arrVehicleInformationData['plate_number_image'] = $new_file_name1;
                }
                $arrVehicleInformationData['user_id'] = $user_id;
                $vehicle_name = isset($request->vehicle_name) && $request->vehicle_name != '' ? $request->vehicle_name : '';
                $arrVehicleInformationData['vehicle_name'] = $vehicle_name;
                $arrVehicleInformationData['vehicle_color'] = isset($request->vehicle_color) ? $request->vehicle_color : '';
                $arrVehicleInformationData['year_manufacture'] = isset($request->year_manufacture) ? $request->year_manufacture : '';
                $arrVehicleInformationData['plate_number'] = $request->plate_number;
                $arrVehicleInformationData['operator_name'] = $request->operator_name;
                $arrVehicleInformationData['contact_person_name'] = $request->contact_person_name;
                $arrVehicleInformationData['contact_person_number'] = $request->contact_person_number;
                $arrVehicleInformationData['status'] = 1;

                $userDriverDetails = DriverAssignedDetail::where('user_id', $user_id)->first();
                $succes_msg = "Driver user vehicle has been added successfully!";
                if (isset($userDriverDetails) && count($userDriverDetails) > 0) {
                    $all_data = UserVehicleInformation::where('id', $userDriverDetails->vehicle_id)->first();
                    if (isset($arrVehicleInformationData['vehicle_image'])) {
                        $all_data->vehicle_image = $arrVehicleInformationData['vehicle_image'];
                    }
                    $all_data->user_id = $user_id;
                    $all_data->vehicle_name = $arrVehicleInformationData['vehicle_name'];
                    $all_data->vehicle_color = $arrVehicleInformationData['vehicle_color'];
                    $all_data->year_manufacture = $arrVehicleInformationData['year_manufacture'];
                    $all_data->plate_number = $arrVehicleInformationData['plate_number'];
                    $all_data->operator_name = $arrVehicleInformationData['operator_name'];
                    $all_data->contact_person_name = $arrVehicleInformationData['contact_person_name'];
                    $all_data->contact_person_number = $arrVehicleInformationData['contact_person_number'];
                    $all_data->status = 1;
                    $all_data->save();
                    $succes_msg = "Driver car details has been updated successfully!";
                } else {
                    $userVehicleInfo = UserVehicleInformation::create($arrVehicleInformationData);
                    $arrDriverData = array();

                    if ($user_id != '' && $user_id != '0') {
                        $arrDriverData['user_id'] = $user_id;
                        $arrDriverData['vehicle_id'] = $userVehicleInfo->id;

                        DriverAssignedDetail::create($arrDriverData);
                    }
                }
            } else {
                $userVehicleInfo = UserVehicleInformation::where('id', $request->vehicle_list)->first();
                $arrVehicleInformationData = array();
                if ($user_id != '' && $user_id != '0') {
                    $arrVehicleInformationData['user_id'] = $user_id;
                    $arrVehicleInformationData['vehicle_id'] = $userVehicleInfo->id;
                }
                DriverAssignedDetail::create($arrVehicleInformationData);
            }
        }
        return redirect("admin/update-driver-user/" . $user_id)->with("vehicle-updated", $succes_msg);
    }

    /**
     * @description This function is used to delete the driver user
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deletDriverUser($user_type,$user_id) {
        $user = User::find($user_id);
        if ($user) {
            $check_driver_active_orders = Order::where('driver_id', $user_id)->get();
            if (count($check_driver_active_orders) == 0) {
                $user->delete();
                return redirect("$user_type/driver-users")->with('delete-user-status', 'Driver user has been deleted successfully!');
            } else {
                return redirect("$user_type/driver-users")->with('already_have_ride', 'This driver have already performed ride, so you can not delete this driver');
            }
        } else {
            return redirect("$user_type/driver-users");
        }
    }

    /**
     * @description This function is used to update driver user email information
     * @param Request $data
     * @param $user_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    protected function updateDriverUserEmailInfo(Request $data, $user_id) {
        $data_values = $data->all();
        if (Auth::user()) {
            $arr_user_data = User::find($user_id);
            $validate_response = Validator::make($data_values, array(
                        'email' => 'required|email|max:500|unique:users,email',
                        'confirm_email' => 'required|email|same:email',
            ));

            if ($validate_response->fails()) {
                return redirect('admin/update-driver-user/' . $user_id)
                                ->withErrors($validate_response)
                                ->withInput();
            } else {
                //updating user email
                $arr_user_data->email = $data->email;
                $arr_user_data->save();

                //updating user status to inactive
                $arr_user_data->userInformation->user_status = 0;
                $arr_user_data->userInformation->save();
                //sending email with verification link
                //sending an email to the user on successfull registration.

                $arr_keyword_values = array();
                $site_email = GlobalValues::get('site-email');
                $site_title = GlobalValues::get('site-title');
                $activation_code = $this->generateReferenceNumber();
                //Assign values to all macros
                $arr_keyword_values['FIRST_NAME'] = $arr_user_data->userInformation->first_name;
                $arr_keyword_values['LAST_NAME'] = $arr_user_data->userInformation->last_name;
                $arr_keyword_values['VERIFICATION_LINK'] = url('verify-user-email/' . $activation_code);
                $arr_keyword_values['SITE_TITLE'] = $site_title;
                $site_url = GlobalValues::get('site-url');
                $facebook_url = GlobalValues::get('facebook-link');
                $instagram_url = GlobalValues::get('instagram-link');
                $youtube_url = GlobalValues::get('youtube-link');
                $twitter_url = GlobalValues::get('twitter-link');
                $arr_keyword_values['SITE_URL'] = $site_url;
                $arr_keyword_values['FACEBOOK_URL'] = $facebook_url;
                $arr_keyword_values['INSTAGRAM_URL'] = $instagram_url;
                $arr_keyword_values['YOUTUBE_URL'] = $youtube_url;
                $arr_keyword_values['TWITTER_URL'] = $twitter_url;
                // updating activation code
                $arr_user_data->userInformation->activation_code = $activation_code;
                $arr_user_data->userInformation->save();
                if(isset($arr_user_data->email) && $arr_user_data->email != ""){
                    // oommented due to smpt detail delay
                   /* @Mail::send('emailtemplate::user-email-change-en', $arr_keyword_values, function ($message) use ($arr_user_data, $site_email, $site_title) {
                        $message->to($arr_user_data->email)->subject("Email Changed Successfully!")->from($site_email, $site_title);
                    });*/
                }
                $succes_msg = "Driver user email has been updated successfully!";
                return redirect("admin/view-driver-user/" . $user_id)->with("email-updated", $succes_msg);
            }
        } else {
            $errorMsg = "Error! Something is wrong going on.";
            Auth::logout();
            return redirect("admin/login")->with("issue-profile", $errorMsg);
        }
    }

    /**
     * @description This function is used to download the file in folder
     * @param Request $data
     * @param $file_id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function DriverUserDocument(Request $data, $file_id) {
        $file = url('/public/media/backend/images/driver-license/') . '/' . $file_id;
        return response()->download($file, $file_id);
    }


    /**
     * @description This function is used to change the driver user status
     * @param Request $request
     */
    public function changeDriverUserStatus(Request $request)
    {
        $data = $request->all();
        $driver_data = UserInformation::where('user_id',$data['user_id'])->first();
        if(isset($driver_data))
        {
            if($driver_data->user_status == '0')
            {
                if($driver_data->user_type == '2')
                {
                    $driver_data->user_status = '1';
                    $driver_data->save();
                    echo json_encode(array("error" => "0", "flag" => "0", "message" => "Account status has been changed successfully."));
                    exit();
                }
                if($driver_data->user_type == '4')
                {
                    $madatory_document = DriverDocument::where('is_mandetory','1')->get();
                    if($madatory_document->count() > 0)
                    {
                        $document = $madatory_document->pluck('id')->toArray();
                        $check_uploaded_document_count = DriverDocumentInformation::whereIn('document_id', $document)->where('user_id', $data['user_id'])->count();
                        if ($check_uploaded_document_count == 3)
                        {
                            $check_verified_document_count = DriverDocumentInformation::whereIn('document_id', $document)->where('user_id', $data['user_id'])->where('status','1')->count();
                            if($check_verified_document_count == 3)
                            {
                                $arr_keyword_values = array();
                                $template = EmailTemplate::where("template_key", "driver-account-activated")->first();

                                $site_email = GlobalValues::get('site-email');
                                $site_title = GlobalValues::get('site-title');
                                //Assign values to all macros
                                $arr_keyword_values['FIRST_NAME'] = $driver_data->first_name;
                                $arr_keyword_values['LAST_NAME'] = $driver_data->last_name;
                                $arr_keyword_values['SITE_TITLE'] = $site_title;
                                $site_url = GlobalValues::get('site-url');
                                $facebook_url = GlobalValues::get('facebook-link');
                                $instagram_url = GlobalValues::get('instagram-link');
                                $youtube_url = GlobalValues::get('youtube-link');
                                $twitter_url = GlobalValues::get('twitter-link');
                                $arr_keyword_values['SITE_URL'] = $site_url;
                                $arr_keyword_values['FACEBOOK_URL'] = $facebook_url;
                                $arr_keyword_values['INSTAGRAM_URL'] = $instagram_url;
                                $arr_keyword_values['YOUTUBE_URL'] = $youtube_url;
                                $arr_keyword_values['TWITTER_URL'] = $twitter_url;
                                //$pdf_path = $this->sendDriverForm($user_details);
                                $email = $driver_data->user->email;
                                $driver_data->user_status = '1';
                                $driver_data->save();
                                if( $email != ""){
                                    // oommented due to smpt detail delay
                                    /*@Mail::send('emailtemplate::driver-account-activated', $arr_keyword_values, function ($message) use ($driver_data, $email, $site_email, $site_title, $template) {
                                        $message->to($email)->subject($template->subject)->from($site_email, $site_title);
                                    });*/
                                }
                                echo json_encode(array("error" => "0", "flag" => "0", "message" => "Account status has been changed successfully."));
                                exit();
                            }
                            else
                            {
                                echo json_encode(array("error" => "1", "error_message" => "Uploaded document not verified yet, so cannot active this user"));
                            }
                        }
                        else
                        {
                            echo json_encode(array("error" => "1", "error_message" => "Please enter required document"));
                        }
                    }
                }
            }
            elseif($driver_data->user_status == '1')
            {
                $driver_data->user_status = '2';
                $driver_data->save();
                echo json_encode(array("error" => "0", "flag" => "0", "message" => "Account status has been changed successfully."));
                exit();
            }
            elseif($driver_data->user_status == '2' || $driver_data->user_status == '3')
            {
                $driver_data->user_status = '1';
                $driver_data->save();
                echo json_encode(array("error" => "0", "flag" => "0", "message" => "Account status has been changed successfully."));
                exit();
            }

        }
    }



    /**
     * @description This function is used to change the driver user status
     * @param Request $request
     */
    public function changeDriverUserStatusBackup(Request $request) {
        $data = $request->all();
        $user_details = UserInformation::where('user_id', '=', $data['user_id'])->first();
        if ($user_details->user_type == '4') {
            $driver_user_rating_details = UserRatingInformation::where('from_id', 0)->where('to_id', $data['user_id'])->first();
            $all_doc_details = Document::where('is_mandetory', '=', 1)->get();
            $id = array();
            $document_name = array();
            $doc_id = array();
            foreach ($all_doc_details as $driver_doc) {
                $id[] = $driver_doc->id;
            }
            $exit_doc = DriverDocumentInformation::where('user_id', '=', $data['user_id'])->where('status', 1)->get();
            $driver_vehicle_details = DriverAssignedDetail::where('user_id', '=', $data['user_id'])->first();
            $driver_payment_methods = UserPaymentMethod::where('user_id', '=', $data['user_id'])->first();
            $userBankDetails = UserBankDetail::where('user_id', $data['user_id'])->first();
            if ($user_details) {
                if (($user_details->user_status == 0) && (count($driver_vehicle_details) <= 0)) {
                    $vehicle_details = '';
                    if (count($driver_vehicle_details) <= 0) {
                        $vehicle_details = 'car details';
                    }

                    $dynamic_msg_str = '';
                    if ($vehicle_details != "") {
                        //$dynamic_msg_str = $vehicle_details;
                    }

                    $error_message = '';
                    if ($dynamic_msg_str != '') {
                        $error_message = 'Please update ' . $dynamic_msg_str . ' before you active this user.';
                    } else {
                        $error_message = 'Please update required details before you active this user.';
                    }

                    echo json_encode(array("error" => "1", "error_message" => $error_message));
                } else {
                    $rand = 0;
                    if ($data['user_status'] == '1' && ($user_details->user_status == 0)) {
                        $arrSubscriptionPlan = array();
                        $updated_service_info = UserServiceInformation::where('user_id', $data['user_id'])->first();
                        if (isset($updated_service_info) && count($updated_service_info) > 0) {
                            $service_plan = SubscriptionPlanTranslation::where('name', 'Free plan')->first();
                            $subscription_plan_Detail = SubscriptionPlanDetail::where('subscription_plan_id', $service_plan->subscription_plan_id)->WHERE('service_id', $updated_service_info->service_id)->first();
                            $arrSubscriptionPlan = new SubscriptionPlanForDriverDetail();
                            $arrSubscriptionPlan->driver_id = $data['user_id'];
                            $arrSubscriptionPlan->subscription_plan_detail_id = $subscription_plan_Detail->id;
                            $expiry_date = Carbon::now()->addDays($subscription_plan_Detail->day);
                            $expiry = $expiry_date->format('Y-m-d');
                            $arrSubscriptionPlan->expiry_date = $expiry;
                            $today_date = date("Y-m-d");
                            $arrSubscriptionPlan->start_date = $today_date;
                            $arrSubscriptionPlan->status = 1;
                            $arrSubscriptionPlan->save();
                            if (count($driver_user_rating_details) == 0) {
                                $driver_user_rating_details = new UserRatingInformation();
                                $driver_user_rating_details->from_id = 0;
                                $driver_user_rating_details->to_id = $user_details->user_id;
                                $driver_user_rating_details->status = '1';
                                $driver_user_rating_details->rating = 5.00;
                                $driver_user_rating_details->save();
                            }
                            $arr_keyword_values = array();
                            $template = EmailTemplate::where("template_key", "driver-account-activated")->first();

                            $site_email = GlobalValues::get('site-email');
                            $site_title = GlobalValues::get('site-title');
                            //Assign values to all macros
                            $arr_keyword_values['FIRST_NAME'] = $user_details->first_name;
                            $arr_keyword_values['LAST_NAME'] = $user_details->last_name;
                            $arr_keyword_values['SITE_TITLE'] = $site_title;
                            $site_url = GlobalValues::get('site-url');
                            $facebook_url = GlobalValues::get('facebook-link');
                            $instagram_url = GlobalValues::get('instagram-link');
                            $youtube_url = GlobalValues::get('youtube-link');
                            $twitter_url = GlobalValues::get('twitter-link');
                            $arr_keyword_values['SITE_URL'] = $site_url;
                            $arr_keyword_values['FACEBOOK_URL'] = $facebook_url;
                            $arr_keyword_values['INSTAGRAM_URL'] = $instagram_url;
                            $arr_keyword_values['YOUTUBE_URL'] = $youtube_url;
                            $arr_keyword_values['TWITTER_URL'] = $twitter_url;
                            $pdf_path = $this->sendDriverForm($user_details);
                            $user_details->user_status = '1';
                            $user_details->save();
                            $email = $user_details->user->email;
                            if($email != ""){
                                // oommented due to smpt detail delay
                                /*@Mail::send('emailtemplate::driver-account-activated', $arr_keyword_values, function ($message) use ($user_details, $email, $site_email, $site_title, $template) {
                                    $message->to($email)->subject($template->subject)->from($site_email, $site_title);
                                });*/
                            }
                            if (isset($user_details->user_id)) {
                                $message = "Your account activated successfully";
                                $arr_push_message = array("sound" => "", "title" => "Gereeb", "text" => $message, "flag" => 'account_activated', 'message' => $message, 'order_id' => 0);
                                $arr_push_message_ios = array();
                                if (isset($user_details->device_id) && $user_details->device_id != '') {
                                    $obj_send_push_notification = new SendPushNotification();
                                    if ($user_details->device_type == '0') {
                                        //sending push notification driver user.
                                        $arr_push_message_android = array();
                                        $arr_push_message_android['to'] = $user_details->device_id;
                                        $arr_push_message_android['priority'] = "high";
                                        $arr_push_message_android['sound'] = "default";
                                        $arr_push_message_android['notification'] = $arr_push_message;
                                        $obj_send_push_notification->androidPushNotification(json_encode($arr_push_message_android), $user_details->device_id, $user_details->user_type);
                                    } else {
                                        $user_type = $user_details->user_type;
                                        $arr_push_message_ios['to'] = $user_details->device_id;
                                        $arr_push_message_ios['priority'] = "high";
                                        $arr_push_message_ios['sound'] = "iOSSound.wav";
                                        $arr_push_message_ios['notification'] = $arr_push_message;
                                        $obj_send_push_notification->iOSPushNotificatonDriver(json_encode($arr_push_message_ios), $user_type);
                                    }
                                }
                            }
                        } else {
                            echo json_encode(array("error" => "0", "flag" => "1", "message" => "Please update driver taxi type before you active this user."));
                            exit();
                        }
                        if (!isset($user_details->user->password)) {
                            $rand = rand(10000, 999999);
                            $message = "Your password for Gereeb Driver App is: " . $rand;
                            //sending sms to verified user
                            $mobile = $user_details->user_mobile;
                            $mobile = $mobile;
                            $mobile_code = str_replace("+", "", $user_details->mobile_code);
                            $mobile_number_to_send = "+" . $mobile_code . "" . $mobile;

                            $user_details->user->password = $rand;
                            $user_details->user->save();
                        }
                        $user_details->user_status = $data['user_status'];
                        $user_details->save();
                        if ($rand > 0) {
                            echo json_encode(array("error" => "0", "message" => "Account status has been changed successfully. Password sent is " . $rand));
                            exit();
                        } else {
                            $user_details->user_status = $data['user_status'];
                            $user_details->save();
                            echo json_encode(array("error" => "0", "message" => "Account status has been changed successfully."));
                            exit();
                        }
                    } else {
                        if ($user_details->user_status == 1) {
                            $user_details->user_status = $data['user_status'];
                            $user_details->save();
                            echo json_encode(array("error" => "0", "flag" => "0", "message" => "Account status has been changed successfully."));
                            exit();
                        } else {
                            $no_of_rejection = GlobalValues::get('no_of_rejection');
                            $today_date = date("m");
                            $order_cancellation_details = DB::table("order_cancelation_details")
                                    ->where('canceled_by_driver', '1')
                                    ->where('user_id', $user_details->user_id)
                                    ->whereRaw('MONTH(created_at) = ?', [$today_date])
                                    ->get();

                            if (count($order_cancellation_details) >= $no_of_rejection) {
                                DB::table('order_cancelation_details')->where('canceled_by_driver', '1')->where('user_id', $user_details->user_id)->whereRaw('MONTH(created_at) = ?', [$today_date])->delete();
                            }
                            $user_details->user_status = $data['user_status'];
                            $user_details->save();
                            if (count($driver_user_rating_details) == 0) {
                                $driver_user_rating_details = new UserRatingInformation();
                                $driver_user_rating_details->from_id = 0;
                                $driver_user_rating_details->to_id = $user_details->user_id;
                                $driver_user_rating_details->status = '1';
                                $driver_user_rating_details->rating = 5.00;
                                $driver_user_rating_details->save();
                            }
                            echo json_encode(array("error" => "0", "flag" => "0", "message" => "Account status has been changed successfully."));
                            exit();
                        }
                    }
                }
            } else {
                /* if something going wrong providing error message.  */
                echo json_encode(array("error" => "1", "error_message" => "Please update required details (vehicle details etc) before you active this user."));
            }
        } else {
            $user_details->user_status = $data['user_status'];
            $user_details->save();
            echo json_encode(array("error" => "0", "message" => "Account status has been changed successfully"));
        }
    }

    /**
     * @description This function is used to show the cities constraint
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function listCitiesContstraint() {
        return view('admin::list-cities-constraint');
    }

    /**
     * @description This function is used to update city constraint
     * @param Request $request
     * @param $city_id
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function updateCityCondriverint(Request $request, $city_id) {
        $city = Route::find($city_id);
        $user_id_login = Auth::user()->id;
        $country_id = 0;
        if ($city) {

            if ($request->method() == "GET") {
                $countries = Country::translatedIn(\App::getLocale())->get();
                $states_info = State::where('country_id', $country_id)->translatedIn(\App::getLocale())->get();
                $arr_service_category = Category::translatedIn(\App::getLocale())->get();
                $arr_service = Service::translatedIn(\App::getLocale())->get();
                $countryServices = CountryServices::where('city_id', $city_id)->where('user_id', $user_id_login)->get();

                return view("admin::update-city-constraint", array('city' => $city, 'city' => $city, 'states' => $states_info, 'countries' => $countries, "categories" => $arr_service_category, "services" => $arr_service, "country_services" => $countryServices));
            } else {
                // validate and proceed
                $data = $request->all();
                $validate_response = Validator::make($data, array(//                            'name' => 'required',
                ));

                if ($validate_response->fails()) {
                    return redirect()->back()->withErrors($validate_response)->withInput();
                } else {

                    CountryServices::where('city_id', $city_id)->where('user_id', $user_id_login)->delete();

                    if (isset($data['services']) && !empty($data['services'])) {

                        for ($i = 0; $i < count($data['services']); $i++) {
                            $arr_countryServices = array();
                            $arr_countryServices["service_id"] = $data['services'][$i];
                            if (isset($data['price_type_' . $data['services'][$i]])) {
                                $arr_countryServices["price_type"] = $data['price_type_' . $data['services'][$i]];
                            }
                            if (isset($data['base_price_' . $data['services'][$i]]) && !empty($data['base_price_' . $data['services'][$i]])) {
                                $arr_countryServices["base_price"] = $data['base_price_' . $data['services'][$i]];
                            }
                            if (isset($data['price_per_km_' . $data['services'][$i]]) && !empty($data['price_per_km_' . $data['services'][$i]])) {
                                $arr_countryServices["price_per_km"] = $data['price_per_km_' . $data['services'][$i]];
                            }
                            if (isset($data['price_per_min_' . $data['services'][$i]]) && !empty($data['price_per_min_' . $data['services'][$i]])) {
                                $arr_countryServices["price_per_min"] = $data['price_per_min_' . $data['services'][$i]];
                            }
                            if (isset($data['price_per_weight_' . $data['services'][$i]]) && !empty($data['price_per_weight_' . $data['services'][$i]])) {
                                $arr_countryServices["price_per_weight"] = $data['price_per_weight_' . $data['services'][$i]];
                            }
                            if (isset($data['unloading_time_' . $data['services'][$i]]) && !empty($data['unloading_time_' . $data['services'][$i]])) {
                                $arr_countryServices["unloading_time"] = $data['unloading_time_' . $data['services'][$i]];
                            }
                            if (isset($data['loading_time_type_' . $data['services'][$i]]) && !empty($data['loading_time_type_' . $data['services'][$i]])) {
                                $arr_countryServices["loading_time_type"] = $data['loading_time_type_' . $data['services'][$i]];
                            }
                            if (isset($data['unloading_time_type_' . $data['services'][$i]]) && !empty($data['unloading_time_type_' . $data['services'][$i]])) {
                                $arr_countryServices["unloading_time_type"] = $data['unloading_time_type_' . $data['services'][$i]];
                            }
                            if (isset($data['loading_time_' . $data['services'][$i]]) && !empty($data['loading_time_' . $data['services'][$i]])) {
                                $arr_countryServices["loading_time"] = $data['loading_time_' . $data['services'][$i]];
                            }
                            if (isset($data['check_point_distance_' . $data['services'][$i]]) && !empty($data['check_point_distance_' . $data['services'][$i]])) {
                                $arr_countryServices["check_point_distance"] = $data['check_point_distance_' . $data['services'][$i]];
                            }
                            if (isset($data['flat_price_' . $data['services'][$i]]) && !empty($data['flat_price_' . $data['services'][$i]])) {
                                $arr_countryServices["flat_price"] = $data['flat_price_' . $data['services'][$i]];
                            }
                            if (isset($data['base_km_' . $data['services'][$i]]) && !empty($data['base_km_' . $data['services'][$i]])) {
                                $arr_countryServices["base_km"] = $data['base_km_' . $data['services'][$i]];
                            }
                            $arr_countryServices["country_id"] = $country_id;
                            $arr_countryServices["city_id"] = $city_id;
                            $arr_countryServices["user_id"] = $user_id_login;
                            CountryServices::create($arr_countryServices);
                        }
                        return redirect('admin/city-constraint/list')->with('update-city-status', 'City constraint has been updated successfully!');
                    } else {
                        return redirect('admin/city-constraint/list')->with('city-status-error', 'Please select atleast one service type');
                    }
                }
            }
        } else {
            return redirect("admin/city-constraint/list");
        }
    }

    /**
     * @description This function is used to get the driver user document information
     * @param Request $data
     * @param $user_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    protected function updateDriverUserDocumentInfo(Request $data, $user_id) {
        $data_values = $data->all();
        if (Auth::user()) {
            $arr_user_data = User::find($user_id);
            if (empty($arr_user_data->driverUserInformation->driver_license_flle)) {
                $validate_response = Validator::make($data_values, array(
                            'driver_license' => 'required|mimes:pdf,png,jpeg',
                            'licence_no' => 'required',
                ));
            } else {

                $validate_response = Validator::make($data_values, array(
                            'licence_no' => 'required',
                ));
            }
            if ($validate_response->fails()) {
                return redirect("admin/update-driver-user/" . $user_id)
                                ->withErrors($validate_response)
                                ->withInput();
            } else {

                $driverUserInformation = array();

                if ($data->file('driver_license')) {
                    $extension = $data->file('driver_license')->getClientOriginalExtension();
                    $new_file_name = time() . "." . $extension;
                    $dir = base_path() . '/' . 'storage/app/public/driver-document';
                    file_put_contents($dir . '/' . $new_file_name, file_get_contents($data->file('driver_license')->getRealPath()));
                    if (isset($arr_user_data->driverUserInformation) && !empty($arr_user_data->driverUserInformation)) {
                        $arr_user_data->driverUserInformation->driver_license_flle = $new_file_name;
                    } else {
                        $driverUserInformation['driver_license_flle'] = $new_file_name;
                    }
                }
                if ($data->file('file')) {
                    $extension = $data->file('file')->getClientOriginalExtension();
                    $new_file_name1 = time() . "." . $extension;
                    $dir = base_path() . '/' . 'storage/app/public/driver-document';
                    file_put_contents($dir . '/' . $new_file_name1, file_get_contents($data->file('file')->getRealPath()));
                    $driverDocument = array();
                    $driverDocument['document_name'] = $data_values['document_name'];
                    $driverDocument['file'] = $new_file_name1;
                    $driverDocument['user_id'] = $user_id;
                    DriverDocument::create($driverDocument);
                }

                if (isset($arr_user_data->driverUserInformation) && !empty($arr_user_data->driverUserInformation)) {
                    $arr_user_data->driverUserInformation->driver_license = $data_values['licence_no'];
                    $arr_user_data->driverUserInformation->id_number = $data_values['id_number'];
                    $arr_user_data->driverUserInformation->save();
                } else {

                    $driverUserInformation['driver_license'] = $data_values['licence_no'];
                    $driverUserInformation['id_number'] = $data_values['id_number'];
                    $driverUserInformation['user_id'] = $user_id;
                    DriverUserInformation::create($driverUserInformation);
                }
                $succes_msg = "Driver user documents has been updated successfully!";
                return redirect("admin/view-driver-user/" . $user_id)->with("profile-updated", $succes_msg);
            }
        } else {
            $errorMsg = "Error! Something wrong is going on.";
            Auth::logout();
            return redirect("login")->with("issue-profile", $errorMsg);
        }
    }

    /**
     * @description This function is used to get services using categories
     * @param Request $request
     */
    public function getServicesByCategory(Request $request) {
        $data = $request->all();
        $html = '';
        if ($data['cat_id'] > 0) {
            $arr_service = Service::translatedIn(\App::getLocale())->get()->where('category_id', $data['cat_id']);

            foreach ($arr_service as $service) {
                $temp_html = '<div class="form-group"><label class="control-label">' . $service->name . '</label>';
                $temp_html = $temp_html . '<input type="checkbox" id="service_' . $service->id . '" name="services_' . $data['cat_id'] . '[]" value="' . $service->id . '" ></div>';
                $html = $html . '' . $temp_html;
            }
            echo $html;
        }
    }

    /**
     * @description This function is used to manage driver user services
     * @param Request $data
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateDriverUserServicesInfo(Request $data, $user_id) {
        $data_values = $data->all();
        if (Auth::user()) {
            if (array_key_exists('category', $data_values)) {
                UserServiceInformation::where('user_id', $user_id)->delete();
                if (array_key_exists('services', $data_values)) {
                    for ($k = 0; $k < count($data_values['services']); $k++) {
                        $arr_services = array();
                        $arr_services["service_id"] = $data_values['services'][$k];
                        $arr_services["user_id"] = $user_id;
                        $arr_services["goe_fence_area"] = $data_values['geo_area_' . $data_values['services'][$k]];
                        $updated_service_info = UserServiceInformation::create($arr_services);
                    }
                }
                $succes_msg = "Driver user Services has been updated successfully!";
                return redirect("admin/view-driver-user/" . $user_id)->with("service-updated", $succes_msg);
            }
        } else {
            $errorMsg = "Error! Something wrong is going on.";
            Auth::logout();
            return redirect("login")->with("issue-service", $errorMsg);
        }
    }

    /**
     * @description This function is used to update the spoken language
     * @param Request $data
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateDriverUserSpokenlanguage(Request $data, $user_id) {
        $data_values = $data->all();
        if (Auth::user()) {
            if (array_key_exists('language', $data_values)) {
                UserSpokenlanguageinformation::where('user_id', $user_id)->delete();
                for ($k = 0; $k < count($data_values['language']); $k++) {
                    $arr_spoken_languages = array();
                    $arr_spoken_languages["spoken_language_id"] = $data_values['language'][$k];
                    $arr_spoken_languages["user_id"] = $user_id;
                    $updated_language_info = UserSpokenlanguageinformation::create($arr_spoken_languages);
                }
                $succes_msg = "Driver user preferred language has been updated successfully!";
                return redirect("admin/view-driver-user/" . $user_id)->with("language-updated", $succes_msg);
            } else {
                UserSpokenlanguageinformation::where('user_id', $user_id)->delete();
                $succes_msg = "Driver user preferred language has been updated successfully!";
                return redirect("admin/view-driver-user/" . $user_id)->with("language-updated", $succes_msg);
            }
        } else {
            $errorMsg = "Error! Something wrong is going on.";
            Auth::logout();
            return redirect("login")->with("issue-language", $errorMsg);
        }
    }

    /**
     * @description This function is used to update driver payment methods
     * @param Request $data
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateDriverPaymentMethods(Request $data, $user_id) {
        $data_values = $data->all();
        dd($data->all());
        if (Auth::user()) {
            $user_pay_methods = UserPaymentMethod::where('user_id', $user_id)->get();
            $succes_msg = "";
            $bank_chk_status = 0;
            $bank_dtls = "";
            if (isset($user_pay_methods) && count($user_pay_methods) > 0) {
                UserPaymentMethod::where('user_id', $user_id)->delete();
            }

            $payment_methods = $data['payment_method'];
            if (count($payment_methods) > 0) {
                foreach ($payment_methods as $method) {
                    $userPaymentMethods['user_id'] = $user_id;
                    $userPaymentMethods['payment_method_id'] = $method;
                    $userPaymentMethods['status'] = 1;
                    UserPaymentMethod::create($userPaymentMethods);
                }
            }
            $userOtherInfo = DriverUserInformation::where('user_id', $user_id)->first();
            $userBankDetails = UserBankDetail::where('user_id', $user_id)->first();
            $deliver_controller = new DeliveryController();

            if (isset($userOtherInfo) && count($userOtherInfo) > 0) {
                if ($userOtherInfo->bank_name != '')
                    $bank_chk_status = 1;
            } else {
                $userOtherInfo = DriverUserInformation::create(array('user_id' => $user_id));
            }
            if (isset($userBankDetails) && count($userBankDetails) > 0) {
                if ($userBankDetails->bank_name != '')
                    $bank_chk_status = 1;
            }

            if ($data['bank_name'] != "") {
                $userOtherInfo->bank_name = $data['bank_name'];
                $userOtherInfo->ifsc_code = $data['ifsc_code'];
                $userOtherInfo->branch_name = $data['branch_name'];
                $acc_number = '';
                $account_number = isset($data['account_number']) && $data['account_number'] != '' ? $data['account_number'] : '';
                if ($account_number != '') {
                    $acc_number = $deliver_controller->encrypt($account_number . "_etriosecretkeyinkwxiihvpaqxwyh");
                }
                $userOtherInfo->account_number = $acc_number;
                $userOtherInfo->save();

                if (count($userBankDetails) == 0) {
                    $userBankDetails = UserBankDetail::create(array('user_id' => $user_id));
                }
                $userBankDetails->bank_detail_id = $data['bank_name'];
                $userBankDetails->branch_code = $data['ifsc_code'];
                $userBankDetails->branch_name = $data['branch_name'];
                $userBankDetails->account_number = $acc_number;
                $userBankDetails->save();
            }

            if ($data['bank_name'] != '') {
                $bank_dtls = $bank_chk_status == 0 ? "Bank details added" : "Bank details updated";
            }
            if ($bank_dtls != '') {
                $succes_msg .= $bank_dtls;
            } else {
                $succes_msg .= "Bank details updated";
            }
            $succes_msg .= " successfully!";
            return redirect("admin/view-driver-user//" . $user_id)->with("payment-method-updated", $succes_msg);
        } else {
            $errorMsg = "Error! Something wrong is going on.";
            Auth::logout();
            return redirect("login")->with("issue-payment_method", $errorMsg);
        }
    }

    /**
     * @description This function is used to manage spoken language (preferred language)
     * @return View
     */
    public function listSpokenlanguage() {
        return view('admin::list-spokenlanguage');
    }

    /**
     * @description This function is used to return all spoken language details
     * @return mixed
     */
    public function listSpokenlanguageData() {
        $all_Spokenlangusge = SpokenLanguage::translatedIn(\App::getLocale())->get();
        return Datatables::collection($all_Spokenlangusge)
                        ->addColumn('Language', function ($Spokenlanguage) {
                            $language = '<button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="langDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Another Language <span class="caret"></span> </button>
                         <ul class="dropdown-menu multilanguage" aria-labelledby="langDropDown">';
                            if (count(config("translatable.locales_to_display"))) {
                                foreach (config("translatable.locales_to_display") as $locale => $locale_full_name) {
                                    if ($locale != 'en') {
                                        $language .= '<li class="dropdown-item"> <a href="update-language/' . $Spokenlanguage->id . '/' . $locale . '">' . $locale_full_name . '</a></li>';
                                    }
                                }
                            }
                            return $language;
                        })->make(true);
    }

    /**
     * @description This function is used to create the spoken language
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|View
     */
    public function createSpokenlanguage(Request $request) {
        if ($request->method() == "GET") {
            return view("admin::create-spokenlanguage");
        } else {
            // validate and proceed
            $data = $request->all();
            $validate_response = Validator::make($data, array(
                        'name' => 'required|unique:country_translations,name',
            ));

            if ($validate_response->fails()) {
                return redirect()->back()->withErrors($validate_response)->withInput();
            } else {
                $Spokenlangusge = SpokenLanguage::create();
                $en_langusge = $Spokenlangusge->translateOrNew(\App::getLocale());

                $en_langusge->name = $request->name;
                $en_langusge->spoken_language_id = $Spokenlangusge->id;
                $en_langusge->save();

                return redirect('admin/preferred-language/list')->with('country-status', 'preferred language has been created Successfully!');
            }
        }
    }

    /**
     * @description This function is used to update the spoken language
     * @param Request $request
     * @param $spoken_id
     * @param $locale
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function updateSpokenlanguage(Request $request, $spoken_id) {
        $Spokenlangusge = SpokenLanguage::find($spoken_id);

        if ($Spokenlangusge) {
            $is_new_entry = !($Spokenlangusge->hasTranslation());
            $translated_spoken_language = $Spokenlangusge->translate();
            if ($request->method() == "GET") {
                return view("admin::update-spokenlanguage", array('country_info' => $translated_spoken_language));
            } else {
                // validate and proceed
                $data = $request->all();
                $validate_response = Validator::make($data, array(
                            'name' => 'required|unique:country_translations,name,' . $translated_spoken_language->id,
                ));

                if ($validate_response->fails()) {
                    return redirect()->back()->withErrors($validate_response)->withInput();
                } else {
                    $translated_spoken_language->name = $request->name;

                    if ($is_new_entry) {
                        $translated_spoken_language->spoken_language_id = $spoken_id;
                    }
                    $translated_spoken_language->save();
                    return redirect('admin/preferred-language/list')->with('update-country-status', 'preferred language has been updated successfully!');
                }
            }
        } else {
            return redirect("admin/preferred-language/list");
        }
    }

    /**
     * @description This function is used to update the spoken language
     * @param Request $request
     * @param $spoken_id
     * @param $locale
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function updateSpokenLang(Request $request, $spoken_id, $locale) {
        $Spokenlangusge = SpokenLanguage::find($spoken_id);

        if ($Spokenlangusge) {
            $is_new_entry = !($Spokenlangusge->hasTranslation($locale));
            $translated_spoken_language = $Spokenlangusge->translateOrNew($locale);
            if ($request->method() == "GET") {
                return view("admin::update-spoken-language", array('country_info' => $translated_spoken_language));
            } else {
                // validate and proceed
                $data = $request->all();
                $validate_response = Validator::make($data, array(
                            'name' => 'required',
                ));
                if ($validate_response->fails()) {
                    return redirect()->back()->withErrors($validate_response)->withInput();
                } else {
                    $translated_spoken_language->name = $request->name;
                    if ($is_new_entry) {
                        $translated_spoken_language->spoken_language_id = $spoken_id;
                    }
                    $translated_spoken_language->save();
                    return redirect('admin/preferred-language/list')->with('update-country-status', 'preferred language updated successfully!');
                }
            }
        } else {
            return redirect("admin/preferred-language/list");
        }
    }

    /**
     * @description This function is used to delete the particular spoken language
     * @param $spoken_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteSpokenlanguage($spoken_id) {
        $Spokenlangusge = SpokenLanguage::find($spoken_id);
        if ($Spokenlangusge) {
            $Spokenlangusge->delete();
            return redirect('admin/preferred-language/list')->with('country-status', 'preferred language has been deleted successfully!');
        } else {
            return redirect("admin/preferred-language/list");
        }
    }

    /**
     * @description This function is used to delete the selected spoken language
     * @param $spoken_id
     */
    public function deleteSpokenlanguageSelected($spoken_id) {
        $Spokenlangusge = SpokenLanguage::find($spoken_id);
        if ($Spokenlangusge) {
            $Spokenlangusge->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

    /**
     * @description This function is used to send notification to passenger
     * @param $arrayToSend
     * @return string
     */
    public function IOSPushNotificaton($arrayToSend) {
        $fcmApiKey = 'AIzaSyCsarbpB9079XBMzmbCN4vH2BCUQXvnbX4'; //App API Key(This is   cloud messaging api key not web api key)
        $url = 'https://fcm.googleapis.com/fcm/send'; //Google URL
        //Fcm Device ids array

        $headers = array(
            'Authorization: key=' . $fcmApiKey,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arrayToSend);
        // Execute post
        $result = curl_exec($ch);
        // Close connection
        curl_close($ch);
        return "1";
    }

    /**
     * @description This function is used to send notification to driver
     * @param $arrayToSend
     * @return string
     */
    public function IOSPushNotificatonDriver($arrayToSend) {
        $fcmApiKey = 'AIzaSyChETgkXysMMEje6m6ei6-OqlvUEkA95Uk'; //App API Key(This is google cloud messaging api key not web api key)
        $url = 'https://fcm.googleapis.com/fcm/send'; //Google URL
        //Fcm Device ids array

        $headers = array(
            'Authorization: key=' . $fcmApiKey,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arrayToSend);
        // Execute post
        $result = curl_exec($ch);
        // Close connection
        curl_close($ch);
        return "1";
    }

    /**
     * @description This function is used to upload driver document
     * @param Request $request
     */
    public function uploadDoc(Request $request) {
        $time = strtotime($request->expiry_date);
        $newformat = date('Y-m-d', $time);
        $driverDocumentinfo = DriverDocumentInformation::where('user_id', $request->user_id)->where('document_id', $request->document_id)->first();
        $image_file_name = !empty($request->file) ? $request->file : '';
        if (isset($driverDocumentinfo) && count($driverDocumentinfo) > 0) {
            if ($request->description != "") {
                $driverDocumentinfo->description = $request->description;
            }
            if ($newformat != "") {
                $driverDocumentinfo->expiry_date = $newformat;
            }
            if ($request->file != "") {
                $driverDocumentinfo->file_name = $request->file;
            }
            if (count($_FILES) > 0 && $_FILES["img_file"]["name"] != '') {
                $test = explode('.', $_FILES["img_file"]["name"]);
                $ext = end($test);
                $image_file_name = time() . '.' . $ext;
                $location = base_path() . '/storage/app/public/driver-document' . '/' . $image_file_name;
                move_uploaded_file($_FILES["img_file"]["tmp_name"], $location);
                if (file_exists(base_path() . '/storage/app/public/driver-document/' . $image_file_name)) {
                    $thumbnail = Image::make(base_path() . '/storage/app/public/driver-document/' . $image_file_name);
                    $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                    $thumbnail->save(base_path() . '/storage/app/public/driver-document/thumbnails/' . $image_file_name);
                }
                $driverDocumentinfo->file = $image_file_name;
            }

            $driverDocumentinfo->status = 1;
            $driverDocumentinfo->save();

            $driver_user_details = Document::where('is_mandetory', '=', 1)->get();
            $id = array();
            $document_name = array();
            foreach ($driver_user_details as $driver_doc) {
                $id[] = $driver_doc->id;
            }
            $exit_doc = DriverDocumentInformation::where('user_id', '=', $request->user_id)->where('status', 1)->get();
            $document_id = array();
            foreach ($exit_doc as $exit) {
                $document_id[] = $exit->document_id;
            }
            $difference = array_diff($id, $document_id);
            $available_driver_details = UserInformation::where('user_id', $request->user_id)->first();
            $existDriverDoc = Document::where('id', $request->document_id)->first();
            echo json_encode(array('document_id' => $request->document_id, 'file_name' => !empty($image_file_name) ? $image_file_name : ''));
            exit();
        } else {
            $created_faq = new DriverDocumentInformation();
            $created_faq->user_id = isset($request->user_id) ? $request->user_id : 0;
            $created_faq->description = isset($request->description) ? $request->description : '';
            $created_faq->expiry_date = $newformat;
            $created_faq->document_id = isset($request->document_id) ? $request->document_id : '';
            $created_faq->file_name = isset($request->file) ? $request->file : '';

            if (count($_FILES) > 0 && $_FILES["img_file"]["name"] != '') {
                $test = explode('.', $_FILES["img_file"]["name"]);
                $ext = end($test);
                $image_file_name = time() . '.' . $ext;
                $location = base_path() . '/storage/app/public/driver-document' . '/' . $image_file_name;
                move_uploaded_file($_FILES["img_file"]["tmp_name"], $location);
                if (file_exists(base_path() . '/storage/app/public/driver-document/' . $image_file_name)) {
                    $thumbnail = Image::make(base_path() . '/storage/app/public/driver-document/' . $image_file_name);
                    $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                    $thumbnail->save(base_path() . '/storage/app/public/driver-document/thumbnails/' . $image_file_name);
                }
                $created_faq->file = $image_file_name;
            }
            $created_faq->status = 1;
            $created_faq->save();
            echo json_encode(array('document_id' => $created_faq->document_id, 'file_name' => !empty($image_file_name) ? $image_file_name : ''));
            exit();
        }
    }

    /**
     * @description This function is used to change user status using driver document status
     * @param Request $request
     */
    public function changedDriverDocumentUserStatus(Request $request) {
        $driverDocumentinfo = DriverDocumentInformation::where('user_id', $request->user_id)->where('document_id', $request->document_id)->first();
        $existDriverDoc = Document::where('id', $request->document_id)->first();

        if ($request->status == 2) {
            if (isset($driverDocumentinfo)) {
                $driverDocumentinfo->status = 2;
                $driverDocumentinfo->save();
                echo "document rejected successfully";
            }
        }
    }

    /**
     * @description This function is used to upload driver document
     * @param Request $request
     */
    public function uploadDoc1(Request $request) {
        if ($_FILES["file"]["name"] != '') {
            $test = explode('.', $_FILES["file"]["name"]);
            $ext = end($test);
            $name = rand(10000, 99999) . '.' . $ext;

            $location = base_path() . 'storage/app/public/driver-document/' . $name;
            move_uploaded_file($_FILES["file"]["tmp_name"], $location);
            echo $name;
        }
    }

    /**
     * @description This function is used to change driver document status
     * @param Request $request
     */
    public function changeDriverUserDocumentStatus(Request $request) {
        $data = $request->all();
        $user_details = UserInformation::where('user_id', '=', $data['user_id'])->first();

        $driver_user_details = Document::where('is_mandetory', '=', 1)->get();
        $id = array();
        $document_name = array();
        foreach ($driver_user_details as $driver_doc) {
            $id[] = $driver_doc->id;
        }
        $exit_doc = DriverDocumentInformation::where('user_id', '=', $data['user_id'])->get();
        $document_id = array();
        foreach ($exit_doc as $exit) {
            $document_id[] = $exit->document_id;
        }
        $difference = array_diff($id, $document_id);

        $non_exist_document = Document::whereIn('id', $difference)->get();
        foreach ($non_exist_document as $doc) {
            $document_name[] = $doc->document_name;
        }
        $document_name = implode(', ', $document_name);
        if (count($difference) > 0) {
            echo json_encode(array("error" => "1", "error_message" => "Please update required $document_name details before you active this status."));
        } else {
            if ($data['user_status'] == 1) {
                if ($user_details->user_status != 0) {
                    $driver_user_details = Document::where('is_mandetory', '=', 1)->get();
                    $id1 = array();
                    $doc_name = array();
                    foreach ($driver_user_details as $driver_doc) {
                        $id1[] = $driver_doc->id;
                    }
                    $reject_driver_doc = DriverDocumentInformation::where('user_id', '=', $data['user_id'])->where('status', 2)->get();

                    $document_id = array();
                    foreach ($reject_driver_doc as $exit1) {
                        $doc_id[] = $exit1->document_id;
                    }
                    $difference1 = array_diff($id1, $doc_id);
                    $non_exist_document = Document::whereIn('id', $difference1)->get();
                    foreach ($non_exist_document as $doc) {
                        $doc_name[] = $doc->document_name;
                    }
                    $doc_name = implode(', ', $doc_name);
                    if (count($difference1) > 0) {
                        echo json_encode(array("error" => "1", "error_message" => "Please update required $doc_name details before you active this status."));
                    } else {
                        $driver_id = $data['user_id'];
                        $query = DB::select("UPDATE " . DB::getTablePrefix() . "driver_document_informations SET `status`='1' WHERE user_id=$driver_id");
                        echo json_encode(array("error" => "0", "flag" => "0", "message" => "Driver Document status has been changed successfully"));
                    }
                } else {
                    echo json_encode(array("error" => "0", "message" => "Driver Document status has been changed successfully"));
                }
            }
            if ($data['user_status'] == 0) {
                if ($user_details->user_status != 0) {
                    $user_details->user_status = 2;
                    $user_details->save();
                    $driver_id = $data['user_id'];
                    $query = DB::select("UPDATE " . DB::getTablePrefix() . "driver_document_informations SET `status`='2' WHERE user_id=$driver_id");
                    echo json_encode(array("error" => "0", "flag" => "1", "message" => "Driver Document status has been changed successfully"));
                } else {
                    $driver_id = $data['user_id'];
                    $query = DB::select("UPDATE " . DB::getTablePrefix() . "driver_document_informations SET `status`='2' WHERE user_id=$driver_id");
                    echo json_encode(array("error" => "0", "message" => "Driver Document status has been changed successfully"));
                }
            }
        }
    }

    /**
     * @description This function is used to update password
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetDriverPassword(Request $request) {
        $created_user = User::create([
                    'email' => $request->email,
                    'password' => $request->password
        ]);
        $successMsg = "Congratulations! your password has been updated successfully.";
        Auth::logout();
        return redirect("login")->with("register-success", $successMsg);
    }

    /**
     * @description This function is used to send notification to driver
     * @param $arrayToSend
     * @return string
     */
    public function AndroidPushNotificatonDriver($arrayToSend) {
        $fcmApiKey = 'AIzaSyC8HdkRg8Asuo1ophJSYdzxJUwAv9Q-mfc'; //App API Key(This is google cloud messaging api key not web api key)
        $url = 'https://fcm.googleapis.com/fcm/send'; //Google URL
        //Fcm Device ids array

        $headers = array(
            'Authorization: key=' . $fcmApiKey,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arrayToSend);
        // Execute post
        $result = curl_exec($ch);
        // Close connection
        curl_close($ch);
        return "1";
    }

    /**
     * @description This function is used to check mobile number is registered or not
     * @param Request $request
     * @param $id
     */
    public function checkMobileNumber(Request $request, $id) {
        $arrUserName = UserInformation::where("user_mobile", $id)->first();
        if (isset($arrUserName) && count($arrUserName) > 0) {
            echo "Entered mobile number is already registered.";
        }
    }

    /**
     * @description This function is used to show password reset view page
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function showPasswordReset() {
        Auth::logout();
        return view('admin::password_reset');
    }

    /**
     * @description This function is used to show password reset view
     * @param Request $request
     * @param $token
     * @return $this
     */
    public function showPasswordResetPost(Request $request, $token) {
        if (is_null($token)) {
            return $this->getEmail();
        }
        $email = $request->input('email');

        if (property_exists($this, 'resetView')) {
            return view($this->resetView)->with(compact('token', 'email'));
        }

        if (view()->exists('auth.passwords.reset')) {
            return view('auth.passwords.reset')->with(compact('token', 'email'));
        }

        return view('auth.reset')->with(compact('token', 'email'));
    }

    /**
     * @description This function is used to show list document details view
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function viewDocumentDetails(Request $request,$user_type) {
        return view("admin::list-document-detail",compact('user_type'));
    }

    /**
     * @description This function is used to show the driver document details
     * @param Request $request
     * @return mixed
     */
    public function allDriverDocument(Request $request) {
        $current_date = date('Y-m-d',strtotime("+30 days"));
        $driver_document = DriverDocumentInformation::where('expiry_date','<',$current_date)->where('document_id','3')->get();
        if(Auth::user()->userInformation->user_type == '3')
        {
            $driver_document = $driver_document->filter(function ($value, $key) {
                return $value->user->userInformation->added_by == Auth::user()->id;
            });
        }
        return Datatables::of($driver_document)
            ->addColumn('user_id', function ($document) {
                return $document->user_id;
            })
            ->addColumn('full_name', function ($document) {
                return $document->user->userInformation->first_name.' '.$document->user->userInformation->last_name;
            })
            ->addColumn('email', function ($document) {
                return $document->user->email;
            })
            ->addColumn('mobile_number', function ($document) {
                return $document->user->username;
            })
            ->addColumn('created_by', function ($document) {
                $type = '';
                $name = $document->user->userInformation->added_by_detail->first_name.' '.$document->user->userInformation->added_by_detail->last_name;
                if($document->user->userInformation->added_by_detail->user_type == '1')
                {
                    $type = '(Admin)';
                }
                else
                {
                    $type = '(Agent)';
                }
                return $name.' '.$type;
            })
            ->addColumn('city', function ($document) {
                return $document->user->userAddress[0]->cityInfo->name;
            })
            ->addColumn('document_name', function ($document) {
                return $document->documentName->document_name;
            })
            ->addColumn('expire_date', function ($document) {
                return $document->expiry_date;
            })
            ->make(true);
        /*$start_date = date('Y-m-d');
        $end_date = date('Y-m-d', strtotime("+31 days"));
        $DriverDocumentinfo = DB::select('SELECT GADDI.id ,GAU.id as user_id,GADT.document_id,GAU.email as user_email,GAUI.first_name,GAUI.last_name,GAUI.user_mobile,GAUI.mobile_code,GADT.document_name,GADDI.expiry_date FROM ' . DB::getTablePrefix() . 'users as GAU LEFT JOIN ' . DB::getTablePrefix() . 'user_informations as GAUI ON GAU.id = GAUI.user_id INNER JOIN ' . DB::getTablePrefix() . 'driver_document_informations AS GADDI ON GAU.id = GADDI.user_id RIGHT JOIN ' . DB::getTablePrefix() . 'documents AS GAD ON GAD.id = GADDI.document_id LEFT JOIN ' . DB::getTablePrefix() . 'document_translations as GADT ON GAD.id = GADT.document_id WHERE (GADDI.status="3" OR GADDI.expiry_date BETWEEN CAST("' . $start_date . '" AS DATE) AND CAST("' . $end_date . '" AS DATE)) AND (GADT.locale="en") ORDER BY user_id DESC');
        $document_info = new Collection($DriverDocumentinfo);
        $i = 0;
        foreach ($document_info as $document) {
            $document_info[$i]->full_name = ((count($document) > 0) ? $document->first_name . " " . $document->last_name : '');
            $document_info[$i]->mobile_number = (count($document) > 0 ? '+' . $document->mobile_code . $document->user_mobile : '');
            $location = '';
            if (count($document) > 0) {
                $location = "Kuwait";
                if ($document->mobile_code == '91')
                    $location = 'India';
            }
            $document_info[$i]->location = $location;
            $document_info[$i]->posted = ((count($document) > 0) ? Carbon::createFromTimeStamp(strtotime($document->expiry_date))->format('m-d-Y') : '');
            $i++;
        }
        return Datatables::of($document_info)
                        ->addColumn('id', function ($document_info) {
                            return count($document_info) > 0 ? $document_info->id : 0;
                        })
                        ->addColumn('full_name', function ($document_info) {
                            return $document_info->full_name;
                        })
                        ->addColumn('email', function ($document_info) {
                            return (count($document_info) > 0 ? $document_info->user_email : '');
                        })
                        ->addColumn('mobile_number', function ($document_info) {
                            return $document_info->mobile_number;
                        })
                        ->addColumn('location', function ($document_info) {
                            return $document_info->location;
                        })
                        ->addColumn('document_name', function ($document_info) {
                            return ((count($document_info) > 0) ? $document_info->document_name : 'NA');
                        })
                        ->addColumn('expire_date', function ($document_info) {
                            return $document_info->posted;
                        })
                        ->make(true);*/
    }

    /**
     * @description This function is used to show the driver document details
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function viewDriverDocumentDetails(Request $request,$user_type, $id) {
        /*$locale = config('app.locale');
        $sql = "SELECT GADDI.id ,GAU.id as user_id,GAD.id as document_id,GAU.email as user_email,GAUI.first_name,GAUI.last_name,GAUI.user_mobile,GAUI.mobile_code,GAUI.user_Status,GAUI.profile_picture,GADT.document_name,";
        $sql .= "GADDI.expiry_date,GAD.discription as doc_description,GAD.file_type as doc_file_type,GADDI.description as driver_description,GADDI.file as driver_file,GADDI.status ";
        $sql .= "FROM " . DB::getTablePrefix() . "users as GAU LEFT JOIN " . DB::getTablePrefix() . "user_informations as GAUI ON GAU.id = GAUI.user_id ";
        $sql .= "INNER JOIN " . DB::getTablePrefix() . "driver_document_informations AS GADDI ON GAU.id = GADDI.user_id ";
        $sql .= "RIGHT JOIN " . DB::getTablePrefix() . "documents AS GAD ON GAD.id = GADDI.document_id ";
        $sql .= "LEFT JOIN " . DB::getTablePrefix() . "document_translations AS GADT ON GAD.id = GADT.document_id ";
        $sql .= "WHERE GADDI.id = $id AND GADT.locale = '$locale' ORDER BY user_id DESC";
        $driver_document_info = DB::select($sql);
        if (isset($driver_document_info) && count($driver_document_info) > 0) {
            $driver_document_info = $driver_document_info[0];
        }
        */
        $driver_document_info = DriverDocumentInformation::find($id);
        return view('admin::view-driver-document-details', compact('driver_document_info','user_type'));
    }


    public function exportPassengerUserData(Request $request)
    {
        $passenger_arr = [];
        $passenger_status = $request->filter_type;
        $passenger = UserInformation::query();
        $passenger = $passenger->where('user_type',5);
        $status_arr = array('0' => 'InActive', '1' => 'Active', '2' => 'Blocked', '3' => 'Suspended');
        if(Auth::user()->userInformation->user_type == '3')
        {
            $passenger = $passenger->where('added_by',Auth::user()->id);
        }
        if(isset($passenger_status) && $passenger_status != '')
        {
            $passenger = $passenger->where('user_status',$passenger_status);
        }
        $passenger = $passenger->orderBy('id','DESC')->get(['id','user_id','first_name','last_name','user_mobile','adhar_number','mobile_code','platform','device_type','user_status','created_at']);
        //dd($passenger);
        if($passenger->count() > 0)
        {
            $platform_arr = array('0' => 'Android', '1' => 'IOS', '2' => 'Web');
            //$device_arr = array('0' => 'Web','1' => 'Android', '2' => 'IOS');
            foreach($passenger as $key => $p)
            {
                $count_of_rides = Order::where('customer_id', $p->user_id)->count();
                $passenger_arr[$key]['Id'] = $p->user_id;
                $passenger_arr[$key]['First Name'] = $p->first_name;
                $passenger_arr[$key]['Last Name'] = $p->last_name;
                $passenger_arr[$key]['Email Id'] = $p->user->email;
                $passenger_arr[$key]['Mobile Number'] = $p->user_mobile;
                $passenger_arr[$key]['Number Of Ride'] = ($count_of_rides > 0) ? $count_of_rides : 'N/A';
                if(isset($p->userRating->rating))
                {
                    $userRating = UserRatingInformation::where('to_id', $p->user_id)->where('status', '1')->avg('rating');
                    $passenger_arr[$key]['Rating'] = isset($userRating) ? round($userRating, 2) : '0';
                }
                else
                {
                    $passenger_arr[$key]['Rating'] = 'N/A';
                }
                if(isset($p->user_status) && $p->user_status != '')
                {
                    $passenger_arr[$key]['Status'] = $status_arr[$p->user_status];
                }
                else
                {
                    $passenger_arr[$key]['Status'] = 'InActive';
                }
                //$passenger_arr[$key]['Status'] = isset($p->user_status) ? $status_arr[$p->user_status] : 'InActive';
                if(isset($p->platform) && $p->platform != '')
                {
                    $passenger_arr[$key]['Platform'] = $platform_arr[$p->platform];
                }
                else
                {
                    $passenger_arr[$key]['Platform'] = 'N/A';
                }
                //$passenger_arr[$key]['Platform'] = isset($p->platform) ? $platform_arr[$p->platform] : 'N/A';
                /*if(isset($p->device_type) && $p->device_type != '')
                {
                    $passenger_arr[$key]['Device'] = $device_arr[$p->device_type];
                }
                else
                {
                    $passenger_arr[$key]['Device'] = 'N/A';
                }*/
                $passenger_arr[$key]['Prefered Language'] = 'English';
                //$passenger_arr[$key]['Device'] = isset($p->device_type) ? $device_arr[$p->device_type] : 'N/A';
                $passenger_arr[$key]['Registered On'] = (isset($p->created_at)) ? Carbon::createFromTimeStamp(strtotime($p->created_at))->format('m/d/Y H:i A') : '';
            }
            return \Maatwebsite\Excel\Facades\Excel::create('Passenger_Report' . '_' . date('d-m-Y'), function ($excel) use ($passenger_arr) {
                $excel->sheet('mySheet', function ($sheet) use ($passenger_arr) {
                    $sheet->fromArray($passenger_arr);
                });
            })->download('xls');
        }
        else
        {
            $message = '';
            if(isset($status_arr[$passenger_status]))
            {
                $message = $status_arr[$passenger_status];
            }
            return Redirect::back()->withErrors(['No '.$message.' Record Found']);
        }
    }

    /**
     * @description This function is used to expload the driver user data
     * @param Request $request
     * @return mixed
     */
   /* public function exportPassengerUserData(Request $request) {
        $order_filter_by = isset($request->hid_status) ? $request->hid_status : '';
        if (Auth::user()->userInformation->user_type == '1') {
            $country_code = 0;
            $country = 0;
            if (Auth::user()->userAddress) {
                foreach (Auth::user()->userAddress as $address) {
                    $country = $address->user_country;
                    $countryData = Country::where('id', $country)->first();
                    $country_code = str_replace("+", "", $countryData->country_code);
                }
            }
            $registered_users = UserInformation::where("user_type", 3)->orderBy('id', 'desc')->get();
            if ($country != 17 && $country != 0) {

                $registered_users = $registered_users->reject(function ($user) use ($country_code) {

                    return (($user->mobile_code != $country_code));
                });
            }
        } else if (Auth::user()->userInformation->user_type == '4' || Auth::user()->userInformation->user_type == '5' || Auth::user()->userInformation->user_type == '6') {
            $mobile_code = str_replace("+", "", Auth::user()->userInformation->mobile_code);

            $all_users = UserInformation::where("user_type", 3)->get();
            $registered_users = $all_users->reject(function ($user) use ($mobile_code) {

                        $mobile_code_customer = str_replace("+", "", $user->mobile_code);
                        return ($user->user_type != 3 || ($mobile_code_customer != $mobile_code));
                    })->values();
        } else {
            $registered_users = UserInformation::where("user_type", 3)->orderBy('id', 'desc')->get();
        }
        if ($order_filter_by != "") {
            $registered_users = $registered_users->filter(function ($all_data) use ($order_filter_by) {
                return ($all_data->user_status == $order_filter_by);
            });
        }
        ob_clean();
        header('Content-Type: application/vnd.ms-excel; charset=utf-8'); //mime type
        header("Content-type:   application/x-msexcel; charset=utf-8");
        $arr_passenger_user = array();
        $i = 0;
        foreach ($registered_users as $user) {
            $arr_passenger_user[$i]["Id"] = $user->user_id;
            $arr_passenger_user[$i]["Full Name"] = (isset($user->first_name)) ? $user->first_name . ' ' . $user->last_name : " ";
            $arr_passenger_user[$i]["Email"] = (isset($user->user->email)) ? $user->user->email : " ";
            $arr_passenger_user[$i]["Mobile"] = (isset($user->user_mobile)) ? "+" . str_replace("+", "", $user->mobile_code) . " " . $user->user_mobile : " ";
            $location = "";
            if ($user->mobile_code == "91") {
                $location = "India";
            } else {
                $location = "Kuwait";
            }
            $arr_passenger_user[$i]["Location"] = $location;
            $no_of_rides = 0;
            $count_of_rides = Order::where('status', 2)->where('customer_id', $user->user_id)->get();
            if (isset($count_of_rides) && count($count_of_rides) > 0) {
                $no_of_rides = count($count_of_rides);
            }
            $arr_passenger_user[$i]["No Of Ride"] = $no_of_rides;
            $avg_rating = 0;
            $userRatingInfo = UserRatingInformation::where('to_id', $user->user_id)->where('status', '1')->avg('rating');
            if (isset($userRatingInfo) && count($userRatingInfo) > 0) {
                $avg_rating = ($userRatingInfo) ? round($userRatingInfo, 2) : '0';
            }
            $arr_passenger_user[$i]["Rating"] = $avg_rating;
            $driver_status = "";
            if ($user->user_status == 0) {
                $driver_status = "Inactive";
            } else if ($user->user_status == 1) {
                $driver_status = "Active";
            } else if ($user->user_status == 3) {
                $driver_status = "Suspended";
            } else {
                $driver_status = "Blocked";
            }
            $device_type = "";
            if ($user->platform == '0') {
                $device_type = "Android";
            } else if ($user->platform == '1') {
                $device_type = "IOS";
            } else {
                $device_type = "Web";
            }
            $arr_passenger_user[$i]["Status"] = $driver_status;
            $arr_passenger_user[$i]["Platform"] = $device_type;
            $date = (isset($user->created_at)) ? Carbon::createFromTimeStamp(strtotime($user->created_at))->format('m-d-Y H:i A') : '';
            $arr_passenger_user[$i]["Registered On"] = $date;
            $i++;
        }
        return \Maatwebsite\Excel\Facades\Excel::create('Passenger_Report' . '_' . date('dmY'), function ($excel) use ($arr_passenger_user) {
                    $excel->sheet('mySheet', function ($sheet) use ($arr_passenger_user) {
                        $sheet->fromArray($arr_passenger_user);
                    });
                })->download('xls');
    }*/

    /**
     * @description This function is used to export the driver user details
     * @param Request $request
     * @return mixed
     */
    public function exportDriverUserData(Request $request) {

        // new code sohel
        $driver_arr = [];
        $status_arr = array('0' => 'InActive', '1' => 'Active', '2' => 'Blocked', '3' => 'Suspended');
        $driver_status = $request->filter_type;
        $drivers = UserInformation::query();
        if(Auth::user()->userInformation->user_type == '1')
        {
            $drivers = $drivers->where('user_type',4);
        }
        else
        {
            $drivers = $drivers->where('user_type','4')->where('added_by',Auth::user()->id);
        }
        if(isset($driver_status) && $driver_status != '')
        {
            $drivers = $drivers->where('user_status',$driver_status);
        }
        $drivers = $drivers->orderBy('id','DESC')->get(['id','user_id','first_name','last_name','user_mobile','mobile_code','platform','device_type','prefer_language','user_status','created_at','added_by']);
        if($drivers->count() > 0)
        {
            $platform_arr = array('0' => 'Android', '1' => 'IOS', '2' => 'Web');
            //$device_arr = array('0' =>'Web','1' => 'Android', '2' => 'IOS');
            $required_document_ids = DriverDocument::where('is_mandetory','1')->pluck('id')->toArray();
            $required_document_count = count($required_document_ids);
            foreach($drivers as $key => $driver)
            {
                $driver_arr[$key]['Id'] = $driver->user_id;
                $driver_arr[$key]['First Name'] = $driver->first_name;
                $driver_arr[$key]['Last Name'] = $driver->last_name;
                $driver_arr[$key]['Email Id'] = $driver->user->email;
                $driver_arr[$key]['Mobile Number'] = $driver->user_mobile;
                $driver_arr[$key]['City'] = isset($driver->userAddressInfo->cityInfo->name) ? $driver->userAddressInfo->cityInfo->name : 'N/A';
                $driver_arr[$key]['State'] = isset($driver->userAddressInfo->stateInfo->name) ? $driver->userAddressInfo->stateInfo->name : 'N/A';
                $driver_arr[$key]['Country'] = isset($driver->userAddressInfo->countryinfo->name) ? $driver->userAddressInfo->countryinfo->name : 'N/A';
                $uploaded_document_count = DriverDocumentInformation::where('user_id',$driver->user_id)->whereIn('document_id',$required_document_ids)->count();
                if($required_document_count == $uploaded_document_count)
                {
                    $document_status = 'Uploaded';
                }
                else
                {
                    $document_status = 'Pending';
                }
                $driver_arr[$key]['Document Status'] = $document_status;
                if(isset($driver->userRating->rating))
                {
                    $userRating = UserRatingInformation::where('to_id', $driver->user_id)->where('status', '1')->avg('rating');
                    $driver_arr[$key]['Rating'] = isset($userRating) ? round($userRating, 2) : '0';
                }
                else
                {
                    $driver_arr[$key]['Rating'] = 'N/A';
                }
                //$driver_arr[$key]['Rating'] = isset($driver->userRating->rating) ? $driver->userRating->rating : 'N/A';
                if(isset($driver->user_status) && $driver->user_status != '')
                {
                    $driver_arr[$key]['Status'] = $status_arr[$driver->user_status];
                }
                else
                {
                    $driver_arr[$key]['Status'] = 'InActive';
                }
                //$driver_arr[$key]['Status'] = isset($driver->user_status) ? $status_arr[$driver->user_status] : 'InActive';
                //$driver_arr[$key]['Platform'] = isset($driver->platform) ? $platform_arr[$driver->platform] : 'N/A';
                if(isset($driver->platform) && $driver->platform != '')
                {
                    $driver_arr[$key]['Platform'] = $platform_arr[$driver->platform];
                }
                else
                {
                    $driver_arr[$key]['Platform'] = 'N/A';
                }
                
                $driver_arr[$key]['Wallet Balance'] = 'INR '. GlobalValues::userBalance($driver->user_id);
                //$driver_arr[$key]['Device'] = isset($driver->device_type) ? $device_arr[$driver->device_type] : 'N/A';
                /*if(isset($driver->device_type) && $driver->device_type != '')
                {
                    $driver_arr[$key]['Device'] = $device_arr[$driver->device_type];
                }
                else
                {
                    $driver_arr[$key]['Device'] = 'N/A';
                }*/
                $driver_arr[$key]['Prefered Language'] = 'English';
                if(isset($driver->added_by))
                {
                    $slug = '';
                    if($driver->added_by_detail->user_type = '3')
                    {
                        $slug = ' (Agent)';
                    }
                    else
                    {
                        $slug = ' (Admin)';
                    }
                    $added_by = $driver->added_by_detail->first_name.' '.$driver->added_by_detail->last_name.$slug;

                }
                else
                {
                    $added_by = 'N/A';
                }
                $driver_arr[$key]['Added By'] = $added_by;
                $driver_arr[$key]['Registered On'] = (isset($driver->created_at)) ? Carbon::createFromTimeStamp(strtotime($driver->created_at))->format('m/d/Y H:i A') : '';
            }
            return \Maatwebsite\Excel\Facades\Excel::create('Driver_Report' . '_' . date('d-m-Y'), function ($excel) use ($driver_arr) {
                $excel->sheet('mySheet', function ($sheet) use ($driver_arr) {
                    $sheet->fromArray($driver_arr);
                });
            })->download('xls');
        }
        else
        {
            $message = '';
            if(isset($status_arr[$driver_status]))
            {
                $message = $status_arr[$driver_status];
            }
            return Redirect::back()->withErrors(['No '.$message.' Record Found']);
        }

        //end new code sohel

        //old code commented
        /*$order_filter_by = isset($request->hid_status) ? $request->hid_status : '';
        $all_users = UserInformation::where("user_type", 4)->get();
        dd($all_users);
        $all_users = $all_users->sortByDesc('id');
        if (Auth::user()->userInformation->user_type == '1') {
            if (Auth::user()->userAddress) {
                foreach (Auth::user()->userAddress as $address) {
                    $country = $address->user_country;
                }
            }
            if ($country != 17) {

                $driver_users = $all_users->reject(function ($user) use ($country) {
                    $driver_country = 0;
                    if ($user->user->userAddress) {

                        foreach ($user->user->userAddress as $address) {
                            $driver_country = $address->user_country;
                        }
                    }
                    return (($user->user_type == '1') || ($user->user_type != 2) || ($driver_country != $country));
                });
            } else {
                $driver_users = $all_users->reject(function ($user) use ($country) {
                    $driver_country = 0;
                    if ($user->user->userAddress) {

                        foreach ($user->user->userAddress as $address) {
                            $driver_country = $address->user_country;
                        }
                    }
                    return (($user->user_type == '1') || ($user->user_type != 2));
                });
            }
        } else if (Auth::user()->userInformation->user_type == '7' || Auth::user()->userInformation->user_type == '5') {

            $driver_users = $all_users->reject(function ($user) {

                return ($user->user->supervisor_id != Auth::user()->id);
            });
        } else if (Auth::user()->userInformation->user_type == '1') {
            $driver_users = $all_users->reject(function ($user) {
                if (isset($user->user)) {
                    return (($user->user_type == '1') || ($user->user_type != 2));
                }
            });
        } else if (Auth::user()->userInformation->user_type == '4') {

            $country = 0;
            $state = 0;
            $city = 0;
            if (Auth::user()->userAddress) {

                foreach (Auth::user()->userAddress as $address) {
                    $country = $address->user_country;
                    $state = $address->user_state;
                    $city = $address->user_city;
                }
            }
            $driver_users = $all_users->reject(function ($user) use ($country, $state, $city) {
                $driver_country = 0;
                $driver_state = 0;
                $driver_city = 0;
                if ($user->user->userAddress) {
                    foreach ($user->user->userAddress as $address) {
                        $driver_country = $address->user_country;
                        $driver_state = $address->user_state;
                        $driver_city = $address->user_city;
                    }
                }

                $condition = (($user->user_type == '1') || ($user->user_type != 2));
                $contry_passed = false;
                $state_passed = false;
                $city_passed = false;
                if ($country != '3') {
                    if ($country != '17') {
                        $contry_passed = ($driver_country != $country);
                    }
                    if ($state != '32') {
                        $state_passed = ($driver_state != $state);
                    }
                    if ($city != '22') {
                        $city_passed = ($driver_city != $city);
                    }
                    return ($condition || ($contry_passed || $state_passed || $city_passed));
                } else {
                    $contry_passed = ($driver_country != $country);
                    if ($state != '5') {
                        return ($condition || ($contry_passed));
                    } else {
                        return ($condition || ($contry_passed || $state_passed));
                    }
                }
            });
        } else if (Auth::user()->userInformation->user_type == '6') {

            $country = 0;
            $state = 0;
            $city = 0;
            if (Auth::user()->userAddress) {

                foreach (Auth::user()->userAddress as $address) {
                    $country = $address->user_country;
                    $state = $address->user_state;
                    $city = $address->user_city;
                }
            }
            $driver_users = $all_users->reject(function ($user) use ($country, $state, $city) {
                $driver_country = 0;
                $driver_state = 0;
                $driver_city = 0;
                if ($user->user->userAddress) {

                    foreach ($user->user->userAddress as $address) {
                        $driver_country = $address->user_country;
                        $driver_state = $address->user_state;
                        $driver_city = $address->user_city;
                    }
                }

                $condition = (($user->user_type == '1') || ($user->user_type != 2));
                $contry_passed = false;
                $state_passed = false;
                $city_passed = false;
                if ($country != '3') {
                    if ($country != '17') {
                        $contry_passed = ($driver_country != $country);
                    }
                    if ($state != '32') {
                        $state_passed = ($driver_state != $state);
                    }
                    if ($city != '22') {
                        $city_passed = ($driver_city != $city);
                    }
                    return ($condition || ($contry_passed || $state_passed || $city_passed));
                } else {
                    $contry_passed = ($driver_country != $country);
                    if ($state != '5') {
                        return ($condition || ($contry_passed));
                    } else {
                        return ($condition || ($contry_passed || $state_passed));
                    }
                }
            });
        }
        if ($order_filter_by != "") {
            $driver_users = $driver_users->filter(function ($all_data) use ($order_filter_by) {
                return ($all_data->user_status == $order_filter_by);
            });
        }
        ob_clean();
        header('Content-Type: application/vnd.ms-excel; charset=utf-8'); //mime type
        header("Content-type:   application/x-msexcel; charset=utf-8");
        $arr_driver_user = array();
        $i = 0;
        foreach ($driver_users as $user) {
            $arr_driver_user[$i]["Id"] = $user->user_id;
            $arr_driver_user[$i]["Full Name"] = (isset($user->first_name)) ? $user->first_name . ' ' . $user->last_name : " ";
            $arr_driver_user[$i]["Email"] = (isset($user->user->email)) ? $user->user->email : " ";
            $arr_driver_user[$i]["Mobile"] = (isset($user->user_mobile)) ? "+" . str_replace("+", "", $user->mobile_code) . " " . $user->user_mobile : " ";
            $avg_rating = 0;
            $query = DB::select("SELECT AVG(rating) AS avg_rating FROM " . DB::getTablePrefix() . "user_rating_informations WHERE  `to_id`= " . $user->user_id . " AND `status` = '1'");
            if (isset($query) && count($query) > 0) {
                $avg_rating = number_format($query[0]->avg_rating, 1, '.', '');
                ;
            }
            $arr_driver_user[$i]["Rating"] = $avg_rating;
            $location = "";
            if ($user->mobile_code == "91") {
                $location = "India";
            } else {
                $location = "Kuwait";
            }
            $arr_driver_user[$i]["Location"] = $location;
            $driver_status = "";
            if ($user->user_status == 0) {
                $driver_status = "Inactive";
            } else if ($user->user_status == 1) {
                $driver_status = "Active";
            } else if ($user->user_status == 3) {
                $driver_status = "Suspended";
            } else {
                $driver_status = "Blocked";
            }
            $arr_driver_user[$i]["Status"] = $driver_status;
            $document_status = "";
            $driver_user_details = Document::where('is_mandetory', '=', 1)->get();
            $id = array();
            foreach ($driver_user_details as $driver_doc) {
                $id[] = $driver_doc->id;
            }

            $exit_doc = DriverDocumentInformation::where('user_id', '=', $user->user->id)->get();

            $inactive_driver_status = DriverDocumentInformation::where('user_id', '=', $user->user->id)->whereIn('status', [0, 2])->get();
            $document_id = array();
            foreach ($exit_doc as $exit) {
                $document_id[] = $exit->document_id;
            }
            $difference = array_diff($id, $document_id);

            if (count($difference) > 0) {
                $document_status = "Inactive";
            } else {
                if (count($inactive_driver_status) > 0) {
                    $document_status = "Inactive";
                } else {
                    $document_status = "Active";
                }
            }
            $arr_driver_user[$i]["Document Status"] = $document_status;
            $device_type = "";
            if ($user->platform == '0') {
                $device_type = "Android";
            } else if ($user->platform == '1') {
                $device_type = "IOS";
            } else {
                $device_type = "Web";
            }
            $arr_driver_user[$i]["Platform"] = $device_type;
            $date = (isset($user->created_at)) ? Carbon::createFromTimeStamp(strtotime($user->created_at))->format('m-d-Y H:i A') : '';
            $arr_driver_user[$i]["Registered On"] = $date;
            $i++;
        }
        return \Maatwebsite\Excel\Facades\Excel::create('Driver_Report' . '_' . date('dmY'), function ($excel) use ($arr_driver_user) {
                    $excel->sheet('mySheet', function ($sheet) use ($arr_driver_user) {
                        $sheet->fromArray($arr_driver_user);
                    });
                })->download('xls');*/
    }

    /**
     * @description This function is used to show dashboard details
     * @return null
     */
    public function dashboardDetail() {
        if (Auth::user()) {
            $dashboard_Detail = DashboardDetail::where('user_id', Auth::user()->id)->first();
            if (isset($dashboard_Detail)) {
                return $dashboard_Detail;
            } else {
                return null;
            }
        }
    }

    /**
     * @description This function is used to remove profile picture from storage
     * @param $file_name
     * @return bool
     */
    private function removeProfilePictureFromStrorage($file_name) {
        $dir = base_path() . '/' . 'storage/app/public/user-images';
        if (file_exists($dir . '/' . $file_name)) {
            unlink($dir . '/' . $file_name);
            return true;
        }
        return false;
    }

    /**
     * @description This function is used to get data filter by time duration
     * @param $data
     * @param $order_drivert_date
     * @param $order_end_date
     * @param $filter_type_reply
     * @return mixed
     */
    public function getDataFilterByTimeDuration($data, $order_drivert_date, $order_end_date, $filter_type_reply) {
        switch ($filter_type_reply) {
            case 1:
                $data = $data->filter(function ($user) {
                    $today_date = date("Y-m-d");
                    return date("Y-m-d", strtotime($user->created_at)) == $today_date;
                });
                break;
            case 2:
                $data = $data->filter(function ($user) {
                    $today_date = date("Y-m-d");
                    $seven_days_back = date('Y-m-d', strtotime('-7 days'));
                    return date("Y-m-d", strtotime($user->created_at)) <= $today_date && date("Y-m-d", strtotime($user->created_at)) >= $seven_days_back;
                });
                break;
            case 3:
                $data = $data->filter(function ($user) {
                    $today_date = date("Y-m-d");
                    $days_back = date('Y-m-d', strtotime('-30 days'));
                    return date("Y-m-d", strtotime($user->created_at)) <= $today_date && date("Y-m-d", strtotime($user->created_at)) >= $days_back;
                });
                break;
            case 4:
                if ($order_drivert_date != "" && $order_end_date != "") {
                    $data = $data->filter(function ($order) use ($order_drivert_date, $order_end_date) {
                        return date("Y-m-d", strtotime($order->created_at)) <= $order_drivert_date && date("Y-m-d", strtotime($order->created_at)) >= $order_end_date;
                    });
                }
                break;
            case 5:
                if ($order_drivert_date != "" && $order_end_date != "") {
                    $data = $data->filter(function ($order) use ($order_drivert_date, $order_end_date) {
                        return date("Y-m-d", strtotime($order->created_at)) <= $order_drivert_date && date("Y-m-d", strtotime($order->created_at)) >= $order_end_date;
                    });
                }
                break;
            default:
                $data = $data;
                break;
        }
        return $data;
    }

    /**
     * @description This function is used to reject the not matching data and return another
     * @param $data
     * @param $key
     * @param $value
     * @return mixed
     */
    public function rejectByKeyValue($data, $key, $value) {
        $data = $data->reject(function ($ride) use ($key, $value) {
            return $ride->$key != $value;
        });
        return $data;
    }

    /**
     * @description This function is used to get user average ratting
     * @param $user_id
     * @return int|string
     */
    private function getUserAvgRating($user_id) {
        $avg_rating = 0;
        $query = DB::select("SELECT AVG(rating) AS avg_rating FROM " . DB::getTablePrefix() . "user_rating_informations WHERE  `to_id`= " . $user_id . " AND `status` = '1'");
        if (isset($query) && count($query) > 0) {
            $avg_rating = number_format($query[0]->avg_rating, 1, '.', '');
        }
        return $avg_rating;
    }

    /**
     * @description This function is used to get user currency code
     * @param $user_id
     * @return string
     */
    public function getUserCurrencyCode($user_id) {
        $currencyCode = 'INR';
        return $currencyCode;
    }

    /**
     * @description This function is used to send driver form
     * @param $user_details
     * @return string
     */
    public function sendDriverForm($user_details) {
        $user_document_details = DriverDocumentInformation::select('expiry_date')->where('user_id', $user_details->user_id)->where('document_id', 5)->first();
        $civil_id_expiry_Date = DriverDocumentInformation::select('expiry_date')->where('user_id', $user_details->user_id)->where('document_id', 7)->first();
        $user_vehicle_details = UserVehicleInformation::where('user_id', $user_details->user_id)->first();
        $email = $user_details->user->email;

        $file_dir = base_path() . '/storage/app/public/driver-registration-form/';
        $file_name = 'driver_registration_form_' . $user_details->user_id . '.pdf';
        $file_path = $file_dir . $file_name;
        ob_clean();
        $pdf = PDF::loadView('admin::view-driver-form', compact('civil_id_expiry_Date', 'user_document_details', 'email', 'user_details', 'user_vehicle_details'));
        if (!file_exists($file_path)) {
            $fh = fopen($file_path, 'w');
            fwrite($fh, "");
        }
        $pdf->save($file_path);
        return $file_path;
    }

    /**
     * @description This function is used to show driver form
     * @param $user_id
     * @return string
     */
    public function viewDriverPDFForm($user_id) {
        $user_details = UserInformation::where('user_id', $user_id)->first();
        if ($user_details) {
            if ($user_details->user_status == '1') {
                $user_document_details = DriverDocumentInformation::select('expiry_date')->where('user_id', $user_id)->where('document_id', 5)->first();
                $user_vehicle_details = UserVehicleInformation::where('user_id', $user_id)->first();
                $email = $user_details->user->email;
                return view('admin::view-driver-form', compact('user_document_details', 'email', 'user_details', 'user_vehicle_details'))->render();
            }
        }
    }

    /**
     * @description This function is used to generate driver registration form in pdf
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generateDriverPDF($user_id) {
        $user_details = UserInformation::where('user_id', $user_id)->first();
        $locale = config('app.locale') ? config('app.locale') : 'en';
        if ($user_details) {
            if ($user_details->user_status == '1') {
                $user_document_details = DriverDocumentInformation::select('expiry_date')->where('user_id', $user_id)->where('document_id', 5)->first();
                $user_vehicle_detail_sql = "SELECT gauvi.contact_person_number,gauvi.year_manufacture,gauvi.contact_person_name,gauvi.plate_number,gauvi.operator_name,gacmt.name as car_model_name,gacct.name as car_color_name FROM " . DB::getTablePrefix() . "driver_assigned_details as gadad LEFT JOIN " . DB::getTablePrefix() . "user_vehicle_informations as gauvi ON gadad.vehicle_id = gauvi.id";
                $user_vehicle_detail_sql .= " LEFT JOIN " . DB::getTablePrefix() . "car_model_translations as gacmt ON gauvi.vehicle_name = gacmt.car_model_id";
                $user_vehicle_detail_sql .= " LEFT JOIN " . DB::getTablePrefix() . "car_color_translations as gacct ON gauvi.vehicle_color = gacct.car_color_id";
                $user_vehicle_detail_sql .= " WHERE gadad.user_id='$user_id' and gacmt.locale = '$locale' and gacmt.locale = '$locale' order by gadad.id desc limit 0,1";
                $user_vehicle_details = DB::select(DB::raw($user_vehicle_detail_sql));
                if (isset($user_vehicle_details) && count($user_vehicle_details) > 0) {
                    $user_vehicle_details = reset($user_vehicle_details);
                }
                $civil_id_expiry_Date = DriverDocumentInformation::select('expiry_date')->where('user_id', $user_id)->where('document_id', 7)->first();
                $user_service_info = UserServiceInformation::where('user_id', $user_id)->first();
                $taxi_type = '';
                if (isset($user_service_info) && count($user_service_info) > 0) {
                    $taxi_type = GlobalValues::getServiceName($user_service_info->service_id);
                }
                $email = $user_details->user->email;
                $file_name = 'driver_registration_form_' . $user_id . '.pdf';

                ob_clean();
                $pdf = PDF::loadView('admin::view-driver-form', compact('civil_id_expiry_Date', 'user_document_details', 'email', 'user_details', 'user_vehicle_details', 'taxi_type'));
                return $pdf->download($file_name);
            } else {
                $errorMsg = "Driver is not yet active. Please activate driver to generate PDF.";
                return redirect("admin/view-driver-user/" . $user_id)->with("msg_error", $errorMsg);
            }
        } else {
            $errorMsg = "Invalid drvier user.";
            return redirect("admin/view-driver-user/" . $user_id)->with("msg_error", $errorMsg);
        }
    }

    /**
     * @description This function is used to return car details using model_id
     * @param $model_id
     */
    public function getCarModelColors($model_id) {
        $car_details = CarDetail::where('car_model_id', $model_id)->where('locale', \App::getLocale())->get();

        $car_colors = array();
        $select_value = '<option value="">--Select--</option>';
        if (isset($car_details) && count($car_details) > 0) {
            foreach ($car_details as $car_detail) {
                $car_color = CarColor::where('id', $car_detail->car_color_id)->translatedIn(\App::getLocale())->get();
                if (isset($car_color) && count($car_color) > 0) {
                    foreach ($car_color as $key => $value) {
                        $select_value .= '<option value="' . $value->id . '">' . $value->name . '</option>';
                    }
                }
            }
        }
        echo $select_value;
        exit;
    }

    /**
     * @description This function is used to generate random string
     * @param string $first_name
     * @return bool|string
     */
    function generateRandomString($first_name = '') {
        /*$words = explode(" ", $first_name);
        $prefix = "";
        foreach ($words as $w) {
            $prefix .= $w[0];
            $prefix .= $w[1];
            $prefix .= $w[2];
        }
        $prefix = strtoupper($prefix);
        $numbers = rand(10000000, 99999999);
        $string = $prefix . substr($numbers, 0, 3);
        $string = substr($string, 0, 6);
        return $string;
         */
        
        $words = trim($first_name);
        $prefix = "";       
        $prefix = strtoupper(mb_substr($words, 0, 3, 'utf-8')); // this changes did to regerate Englis as well as Arabic char
        $numbers = rand(10000000, 99999999);
        //$string = $prefix . substr($numbers, 0, 3); // There was problem with Arabic & Numeric promo code, so removed string data 7th Oct 2019
        $string = substr($numbers, 0, 6);
        //$string = substr($string, 0, 6);
        return $string;
    }

    /**
     * @description This function is used to return key of array
     * @param $obj
     * @return array
     */
    public function getKeysInArray($obj) {
        $ret_array = array();
        foreach ($obj as $item) {
            $ret_array[] = $item->id;
        }
        return $ret_array;
    }

    /**
     * @description This function is used to return total count of array that are belongs in zones
     * @param $obj
     * @param $ids
     * @param $all_zones
     * @return array
     */
    public function getCountInArray($obj, $ids, $all_zones) {
        $ret_array = array();
        foreach ($all_zones as $zone) {
            if (in_array($zone->id, $ids)) {
                $key = array_search($zone->id, $ids);
                $ret_array[] = $obj[$key]->total;
            } else {
                $ret_array[] = 0;
            }
        }

        return $ret_array;
    }

    /**
     * @description This function is used to return zone wise count
     * @param $all_zones
     * @param $obj
     * @return array
     */
    public function getZoneWiseCount($all_zones, $obj) {
        $ids = array();
        $count = array();
        if (isset($obj) && count($obj) > 0) {
            $ids = $this->getKeysInArray($obj);
        }

        if (isset($all_zones) && count($all_zones) > 0) {
            $count = $this->getCountInArray($obj, $ids, $all_zones);
        }
        return $count;
    }

    /**
     * @description This function is used to add reason for suspending the driver
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function addSuspendedDriverReason(Request $request) {
        $user_suspended_reason = new UserSuspendedReason();
        $user_suspended_reason->user_id = $request->user_id;
        $user_suspended_reason->reason = $request->reason;
        $user_suspended_reason->save();

        $user_info = UserInformation:: where("user_id", $user_suspended_reason->user_id)->first();

        if ($user_info->user_status == 1) {
            $user_info->user_status = '3';
            $user_info->save();
        }
        return redirect("admin/driver-users");
    }

    /**
     * @description This function is used to add reason for suspending the passenger
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function addSuspendedPassengerReason(Request $request) {
        $user_suspended_reason = new UserSuspendedReason();
        $user_suspended_reason->user_id = $request->user_id;
        $user_suspended_reason->reason = $request->reason;
        $user_suspended_reason->save();

        $user_info = UserInformation:: where("user_id", $user_suspended_reason->user_id)->first();
        if ($user_info->user_status == 1) {
            $user_info->user_status = '3';
            $user_info->save();
        }
        return redirect("admin/manage-users");
    }

    /**
     * @description This function is used to change the driver user status when he is suspended
     * @param Request $request
     * @return int
     */
    public function changeSuspendedStatus(Request $request) {
        $user_info = UserInformation:: where("user_id", $request->user_id)->first();
        if ($user_info->user_status == 3) {
            $user_info->user_status = '1';
            $user_info->save();
        } else {
            $user_info->user_status = '3';
            $user_info->save();
        }
        return 1;
    }

    /**
     * @description This function is used to change the driver user status
     * @param Request $request
     * @return int|string
     */
    public function changeActiveStatus(Request $request) {
        $status = '';
        $user_info = UserInformation:: where("user_id", $request->user_id)->first();
        if (($user_info->user_status == 3) || ($user_info->user_status == 2))
        {
            $user_info->user_status = '1';
            $user_info->save();
            $status = 1;
        }
        elseif ($user_info->user_status == 0)
        {
            $required_document = DriverDocument::where('is_mandetory','1')->count();
            $uploaded_document = DriverDocumentInformation::where('user_id',$request->user_id)->count();
            if($uploaded_document < $required_document)
            {
                $status = 2;
            }
            else
            {
                $arrSubscriptionPlan = array();
                $driver_user_rating_details = UserRatingInformation::where('from_id', 0)->where('to_id', $request->user_id)->first();
                $updated_service_info = UserServiceInformation::where('user_id', $request->user_id)->first();
                if (isset($updated_service_info) && count($updated_service_info) > 0)
                {
                    $service_plan = SubscriptionPlanTranslation::where('name', 'Free plan')->first();
                    $subscription_plan_Detail = SubscriptionPlanDetail::where('subscription_plan_id', $service_plan->subscription_plan_id)->WHERE('service_id', $updated_service_info->service_id)->first();
                    $arrSubscriptionPlan = new SubscriptionPlanForDriverDetail();
                    $arrSubscriptionPlan->driver_id = $request->user_id;
                    $arrSubscriptionPlan->subscription_plan_detail_id = $subscription_plan_Detail->id;
                    $expiry_date = Carbon::now()->addDays($subscription_plan_Detail->day);
                    $expiry = $expiry_date->format('Y-m-d');
                    $arrSubscriptionPlan->expiry_date = $expiry;
                    $today_date = date("Y-m-d");
                    $arrSubscriptionPlan->start_date = $today_date;
                    $arrSubscriptionPlan->status = 1;
                    $arrSubscriptionPlan->save();
                    $user_details = UserInformation::where('user_id', $request->user_id)->first();
                    if (count($driver_user_rating_details) == 0) {
                        $driver_user_rating_details = new UserRatingInformation();
                        $driver_user_rating_details->from_id = 0;
                        $driver_user_rating_details->to_id = $user_details->user_id;
                        $driver_user_rating_details->status = '1';
                        $driver_user_rating_details->rating = 5.00;
                        $driver_user_rating_details->save();
                    }
                    $arr_keyword_values = array();
                    $template = EmailTemplate::where("template_key", "driver-account-activated")->first();

                    $site_email = GlobalValues::get('site-email');
                    $site_title = GlobalValues::get('site-title');
                    //Assign values to all macros
                    $arr_keyword_values['FIRST_NAME'] = $user_details->first_name;
                    $arr_keyword_values['LAST_NAME'] = $user_details->last_name;
                    $arr_keyword_values['SITE_TITLE'] = $site_title;
                    $site_url = GlobalValues::get('site-url');
                    $facebook_url = GlobalValues::get('facebook-link');
                    $instagram_url = GlobalValues::get('instagram-link');
                    $youtube_url = GlobalValues::get('youtube-link');
                    $twitter_url = GlobalValues::get('twitter-link');
                    $arr_keyword_values['SITE_URL'] = $site_url;
                    $arr_keyword_values['FACEBOOK_URL'] = $facebook_url;
                    $arr_keyword_values['INSTAGRAM_URL'] = $instagram_url;
                    $arr_keyword_values['YOUTUBE_URL'] = $youtube_url;
                    $arr_keyword_values['TWITTER_URL'] = $twitter_url;
                    $pdf_path = $this->sendDriverForm($user_details);
                    $user_details->user_status = '1';
                    $user_details->save();
                    $email = $user_details->user->email;
                    if($email !=""){
                        // oommented due to smpt detail delay
                        /*@Mail::send('emailtemplate::driver-account-activated', $arr_keyword_values, function ($message) use ($user_details, $email, $site_email, $site_title, $template) {
                            $message->to($email)->subject($template->subject)->from($site_email, $site_title);
                        });*/
                    }
                    if (isset($user_details->user_id)) {
                        $message = "Your account activated successfully";
                        $arr_push_message = array("sound" => "", "title" => "Gereeb", "text" => $message, "flag" => 'account_activated', 'message' => $message, 'order_id' => 0);
                        $arr_push_message_ios = array();
                        if (isset($user_details->device_id) && $user_details->device_id != '') {
                            $obj_send_push_notification = new SendPushNotification();
                            if ($user_details->device_type == '0') {
                                //sending push notification driver user.
                                $arr_push_message_android = array();
                                $arr_push_message_android['to'] = $user_details->device_id;
                                $arr_push_message_android['priority'] = "high";
                                $arr_push_message_android['sound'] = "default";
                                $arr_push_message_android['notification'] = $arr_push_message;
                                $obj_send_push_notification->androidPushNotification(json_encode($arr_push_message_android), $user_details->device_id, $user_details->user_type);
                            } else {
                                $user_type = $user_details->user_type;
                                $arr_push_message_ios['to'] = $user_details->device_id;
                                $arr_push_message_ios['priority'] = "high";
                                $arr_push_message_ios['sound'] = "iOSSound.wav";
                                $arr_push_message_ios['notification'] = $arr_push_message;
                                $obj_send_push_notification->iOSPushNotificatonDriver(json_encode($arr_push_message_ios), $user_type);
                            }
                        }
                    }
                }
                $user_info->user_status = '1';
                $user_info->save();
                $status = 1;
            }

            /*$driver_vehicle_details = UserVehicleInformation::where('user_id', '=', $request->user_id)->first();
            $updated_service_info = UserServiceInformation::where('user_id', $request->user_id)->first();
            if ((count($driver_vehicle_details) <= 0)) {
                $error_message = 'Please update car details before you active this user.';
                $status = 2;
            } elseif (count($updated_service_info) <= 0) {
                $error_message = 'Please update driver taxi type before you active this user.';
                $status = 3;
            } else {
                $arrSubscriptionPlan = array();
                $driver_user_rating_details = UserRatingInformation::where('from_id', 0)->where('to_id', $request->user_id)->first();
                $updated_service_info = UserServiceInformation::where('user_id', $request->user_id)->first();
                if (isset($updated_service_info) && count($updated_service_info) > 0) {
                    $service_plan = SubscriptionPlanTranslation::where('name', 'Free plan')->first();
                    $subscription_plan_Detail = SubscriptionPlanDetail::where('subscription_plan_id', $service_plan->subscription_plan_id)->WHERE('service_id', $updated_service_info->service_id)->first();
                    $arrSubscriptionPlan = new SubscriptionPlanForDriverDetail();
                    $arrSubscriptionPlan->driver_id = $request->user_id;
                    $arrSubscriptionPlan->subscription_plan_detail_id = $subscription_plan_Detail->id;
                    $expiry_date = Carbon::now()->addDays($subscription_plan_Detail->day);
                    $expiry = $expiry_date->format('Y-m-d');
                    $arrSubscriptionPlan->expiry_date = $expiry;
                    $today_date = date("Y-m-d");
                    $arrSubscriptionPlan->start_date = $today_date;
                    $arrSubscriptionPlan->status = 1;
                    $arrSubscriptionPlan->save();
                    $user_details = UserInformation::where('user_id', $request->user_id)->first();
                    if (count($driver_user_rating_details) == 0) {
                        $driver_user_rating_details = new UserRatingInformation();
                        $driver_user_rating_details->from_id = 0;
                        $driver_user_rating_details->to_id = $user_details->user_id;
                        $driver_user_rating_details->status = '1';
                        $driver_user_rating_details->rating = 5.00;
                        $driver_user_rating_details->save();
                    }
                    $arr_keyword_values = array();
                    $template = EmailTemplate::where("template_key", "driver-account-activated")->first();

                    $site_email = GlobalValues::get('site-email');
                    $site_title = GlobalValues::get('site-title');
                    //Assign values to all macros
                    $arr_keyword_values['FIRST_NAME'] = $user_details->first_name;
                    $arr_keyword_values['LAST_NAME'] = $user_details->last_name;
                    $arr_keyword_values['SITE_TITLE'] = $site_title;
                    $site_url = GlobalValues::get('site-url');
                    $facebook_url = GlobalValues::get('facebook-link');
                    $instagram_url = GlobalValues::get('instagram-link');
                    $youtube_url = GlobalValues::get('youtube-link');
                    $twitter_url = GlobalValues::get('twitter-link');
                    $arr_keyword_values['SITE_URL'] = $site_url;
                    $arr_keyword_values['FACEBOOK_URL'] = $facebook_url;
                    $arr_keyword_values['INSTAGRAM_URL'] = $instagram_url;
                    $arr_keyword_values['YOUTUBE_URL'] = $youtube_url;
                    $arr_keyword_values['TWITTER_URL'] = $twitter_url;
                    $pdf_path = $this->sendDriverForm($user_details);
                    $user_details->user_status = '1';
                    $user_details->save();
                    $email = $user_details->user->email;
                    if($email != ""){
                        @Mail::send('emailtemplate::driver-account-activated', $arr_keyword_values, function ($message) use ($user_details, $email, $site_email, $site_title, $template) {
                            $message->to($email)->subject($template->subject)->from($site_email, $site_title);
                        });
                    }   
                    if (isset($user_details->user_id)) {
                        $message = "Your account activated successfully";
                        $arr_push_message = array("sound" => "", "title" => "Gereeb", "text" => $message, "flag" => 'account_activated', 'message' => $message, 'order_id' => 0);
                        $arr_push_message_ios = array();
                        if (isset($user_details->device_id) && $user_details->device_id != '') {
                            $obj_send_push_notification = new SendPushNotification();
                            if ($user_details->device_type == '0') {
                                //sending push notification driver user.
                                $arr_push_message_android = array();
                                $arr_push_message_android['to'] = $user_details->device_id;
                                $arr_push_message_android['priority'] = "high";
                                $arr_push_message_android['sound'] = "default";
                                $arr_push_message_android['notification'] = $arr_push_message;
                                $obj_send_push_notification->androidPushNotification(json_encode($arr_push_message_android), $user_details->device_id, $user_details->user_type);
                            } else {
                                $user_type = $user_details->user_type;
                                $arr_push_message_ios['to'] = $user_details->device_id;
                                $arr_push_message_ios['priority'] = "high";
                                $arr_push_message_ios['sound'] = "iOSSound.wav";
                                $arr_push_message_ios['notification'] = $arr_push_message;
                                $obj_send_push_notification->iOSPushNotificatonDriver(json_encode($arr_push_message_ios), $user_type);
                            }
                        }
                    }
                }
                $user_info->user_status = '1';
                $user_info->save();
                $status = 1;
            }*/
        }
        else {
            $user_info->user_status = '2';
            $user_info->save();
            $status = 1;
        }
        return $status;
    }

    /**
     * @description This function is used to check current password
     * @param Request $request
     * @param $id
     * @return string
     */
    protected function chkCurrentPassword(Request $request, $id) {
        $current_password = $request->new_password;
        $user_info = User::find($id);
        if ($current_password) {
            $user_status = Hash::check($current_password, $user_info->password);
            if ($user_status) {
                return "false";
            } else {
                return "true";
            }
        }
    }

    /**
     * @description This function is used to used for create passenger refund amount
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getPassengerRefundAmount(Request $request) {

    }

    /**
     * @description This function is used to price conversion formula
     * @param string $price
     * @return float|string
     */
    public function priceConversionAfterDecimal($price = '') {
        $pri = '0.000';
        $tmp_val = explode('.', $price);
        $temp = 0;
        if (count($tmp_val) > 1) {
            $val = str_split($tmp_val[1]);
            if (isset($val[1]) && (($val[1] == '5') || ($val[1] == '4') || ($val[1] == '3') || ($val[1] == '2') || ($val[1] == '1'))) {
                $pri = $tmp_val[0] . '.' . $val[0] . '5';
            } elseif (isset($val[1]) && (($val[1] == '9') || ($val[1] == '8') || ($val[1] == '7') || ($val[1] == '6'))) {
                if ($val[0] == '9') {
                    $pri = round($price);
                } else {
                    $temp = 10 - $val[1];
                    $temp = substr($tmp_val[1], '0', '2') + $temp;
                    $pri = $tmp_val[0] . '.' . $temp;
                }
            } else {
                $pri = $tmp_val[0] . '.' . $val[0] . '0';
            }
        } else {
            $pri = $price;
        }
        return $pri;
    }
/**
 * This function is return user_type wise user details
 */
    public function getAllDriverCustomerUsers() {


    }
/**
 * 
 * @return typeThis function is used for view the nationality listing
 */
    public function getNationalityDetails() {
        return view("admin::list-nationalities");
    }
/**
 * This function is used for get nationality data
 * @param Request $request
 * @return type
 */
    public function nationalitiesPageDataAdmin(Request $request) {

    }
/**
 * This function is used for update english country name
 * @param Request $request
 * @param type $page_id
 * @return type
 */
    public function updateNationalitiesDetails(Request $request, $page_id = '') {
        $nationality_details = Nationality::find($page_id);
        if ($nationality_details) {
            if ($request->method() == "GET") {
                return view("admin::edit-nationality", ["nationality_details" => $nationality_details]);
            } else {
                // validate request
                $data = $request->all();
                $validate_response = Validator::make($data, [
                            'country_name' => 'required'
                ]);

                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                } else {
                    $nationality_details->country_name = $request->country_name;
                    $nationality_details->save();
                    return redirect('admin/nationality-details')->with('status', 'nationality has been updated Successfully!');
                }
            }
        } else {
            return redirect("admin/nationality-details");
        }
    }
/**
 * This function is used for update the arebic language country name
 * @param Request $request
 * @param type $page_id
 * @param type $locale
 * @return type
 */
    public function showUpdateNationalityLanguageForm(Request $request, $page_id, $locale) {
        $nationality_details = Nationality::find($page_id);
        if ($nationality_details) {

            if ($request->method() == "GET") {
                return view("admin::edit-language-nationality", ["page" => $nationality_details]);
            } else {
                // validate request
                $data = $request->all();
                $validate_response = Validator::make($data, [
                           // 'country_name_arabic' => 'required'
                ]);

                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                } else {

                    if ($nationality_details) {
                        $nationality_details->country_name_arabic = $request->country_name_arabic;
                    }

                    $nationality_details->save();

                    return redirect("admin/nationality-details")->with('status', 'Updated Successfully!');
                }
            }
        } else {
            return redirect("admin/nationality-details");
        }
    }



    // SOhel functions

    public function exportStateList(Request $request)
    {
        $all_states = State::query();
        if(isset($request->filter_type) && $request->filter_type != '')
        {
            $all_states = $all_states->where('status',$request->filter_type);
        }
        $all_states = $all_states->translatedIn(\App::getLocale())->get();
        if($all_states->count() > 0)
        {
            $data = Date('d-m-Y');
            $filename = "State_Report_$data.csv";
            $state_arr = [];
            foreach($all_states as $key => $state)
            {
                $state_arr[$key]['Id'] = $state->id;
                $state_arr[$key]['Country Name'] = $state->country->name;
                $state_arr[$key]['State Name'] = $state->name;
                if($state->status == '0')
                {
                    $state_arr[$key]['Status'] = 'Inactive';
                }
                else
                {
                    $state_arr[$key]['Status'] = 'Active';
                }
                $state_arr[$key]['Created On'] = $state->created_at;
            }
            $this->exportCSV($state_arr,$filename);
            exit;
        }
        else
        {
            return Redirect::back()->withErrors(['No Record Found']);
        }
    }


    public function exportCityList(Request $request)
    {
        $all_cities = City::query();
        if(isset($request->city_filter_type) && $request->city_filter_type != '')
        {
            $all_cities = $all_cities->where('status',$request->city_filter_type);
        }
        $all_cities = $all_cities->translatedIn(\App::getLocale())->get();
        if($all_cities->count() > 0)
        {
            $data = Date('d-m-Y');
            $filename = "City_Report_$data.csv";
            $cities_arr = [];
            foreach($all_cities as $key => $city)
            {
                $cities_arr[$key]['Id'] = $city->id;
                $cities_arr[$key]['Country Name'] = $city->country->name;
                $cities_arr[$key]['State Name'] = $city->state->name;
                $cities_arr[$key]['City Name'] = $city->name;
                if($city->status == '1')
                {
                    $cities_arr[$key]['Status'] = 'Active';
                }
                else
                {
                    $cities_arr[$key]['Status'] = 'Inactive';
                }
                $cities_arr[$key]['Created On'] = $city->created_at;
            }
            $this->exportCSV($cities_arr,$filename);
            exit;
        }
        else
        {
            return Redirect::back()->withErrors(['No Record Found']);
        }

    }

    public function exportCSV($array,$filename)
    {
        $df = fopen("php://output", 'w');
        fputcsv($df, array_keys(reset($array)));
        foreach ($array as $row) {
            fputcsv($df, $row);
        }
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename='.$filename);
        fclose($df);
    }



    public function updateCityFare(Request $request)
    {
        $check_availability = CountryZoneService::where('id',$request->id)->where('zone_id',$request->city_id)->where('service_id',$request->type)->first();
        if(isset($check_availability))
        {
            $check_availability->base_price = $request->base_price;
            $check_availability->base_distance = $request->base_distance;
            $check_availability->charge_per_km = $request->charge_per_km;
            $check_availability->range_for_travelling = $request->range_for_travelling;
            $check_availability->night_time_from = $request->night_time_from;
            $check_availability->night_time_to = $request->night_time_to;
            $check_availability->night_charge_base_price = $request->night_charge_base_price;
            $check_availability->night_charge_per_km = $request->night_charge_per_km;
            $check_availability->max_search_time = $request->max_search_time;
            $check_availability->cancellation_fees = $request->cancellation_fees;
            $check_availability->driver_pickup_waiting_time = $request->driver_pickup_waiting_time;
            $check_availability->passenger_pickup_waiting_time = $request->passenger_pickup_waiting_time;
            $check_availability->no_show_fees_for_passenger = $request->no_show_fees_for_passenger;
            $check_availability->no_show_fees_for_driver = $request->no_show_fees_for_driver;

            $check_availability->driver_no_show_suspension_time = $request->driver_no_show_suspension_time;
            $check_availability->passenger_no_show_suspension_time = $request->passenger_no_show_suspension_time;
            $check_availability->accepting_limit = $request->accepting_limit;
            if($check_availability->save())
            {
                $result = array('status' => '0','msg'=>'Updated Successfully');
                return json_encode($result);
            }

        }
        else
        {
            $insert_fare = new CountryZoneService();
            $insert_fare->zone_id = $request->city_id;
            $insert_fare->service_id = $request->type;
            $insert_fare->base_price = $request->base_price;
            $insert_fare->base_distance = $request->base_distance;
            $insert_fare->charge_per_km = $request->charge_per_km;
            $insert_fare->range_for_travelling = $request->range_for_travelling;
            $insert_fare->night_time_from = $request->night_time_from;
            $insert_fare->night_time_to = $request->night_time_to;
            $insert_fare->night_charge_base_price = $request->night_charge_base_price;
            $insert_fare->night_charge_per_km = $request->night_charge_per_km;
            $insert_fare->max_search_time = $request->max_search_time;
            $insert_fare->cancellation_fees = $request->cancellation_fees;
            $insert_fare->driver_pickup_waiting_time = $request->driver_pickup_waiting_time;
            $insert_fare->passenger_pickup_waiting_time = $request->passenger_pickup_waiting_time;
            $insert_fare->no_show_fees_for_passenger = $request->no_show_fees_for_passenger;
            $insert_fare->no_show_fees_for_driver = $request->no_show_fees_for_driver;
            $insert_fare->driver_no_show_suspension_time = $request->driver_no_show_suspension_time;
            $insert_fare->passenger_no_show_suspension_time = $request->passenger_no_show_suspension_time;
            $insert_fare->accepting_limit = $request->accepting_limit;
            if($insert_fare->save())
            {
                $result = array('status' => '0','msg'=>'Updated Successfully');
                return json_encode($result);
            }
        }



    }

    public function cityFare(Request $request)
    {
        $type = $request->type;
        $city_id = $request->id;
        $city_fare = CountryZoneService::select('id','zone_id','service_id','base_price','base_distance','charge_per_km','range_for_travelling','night_time_from','night_time_to','night_charge_base_price','night_charge_per_km','max_search_time','cancellation_fees','driver_pickup_waiting_time','passenger_pickup_waiting_time','no_show_fees_for_passenger','no_show_fees_for_driver','driver_no_show_suspension_time','passenger_no_show_suspension_time','accepting_limit')->where('zone_id',$city_id)->where('service_id',$type)->first();
        if(isset($city_fare))
        {
            return json_encode($city_fare);
        }
    }

    public function getCitiesAccordingToState(Request $request)
    {
        if(Auth::user()->userInformation->user_type == '3')
        {
            $agent_city_id = Auth::user()->userAddress[0]->user_city;
            $cities = City::select('id')->translatedIn(\App::getLocale())->where('state_id',$request->state_id)->where('id',$agent_city_id)->get()->toArray();
        }
        else
        {
            $cities = City::select('id')->translatedIn(\App::getLocale())->where('state_id',$request->state_id)->get()->toArray();
        }
        if($cities)
        {
            $result = array('status' => '1','cities' => $cities);
            return json_encode($result);
        }
        else
        {
            $result = array('status' => '0');
            return json_encode($result);
        }
    }

    public function getHubAccordingToCity(Request $request)
    {

        $hub_info = Hub::where('hub_city','like', '%' . $request->city_name. '%')->get();
        if($hub_info)
        {
            $result = array('status' => '1','hubs' => $hub_info);
            return json_encode($result);
        }
        else
        {
            $result = array('status' => '0');
            return json_encode($result);
        }
    }

    // remote validation function to validate driver email
    public function validateDriverEmail(Request $request)
    {
        $email = $request->email;
        $user_type = $request->type;
        if(isset($email) && isset($user_type))
        {
            $check_email = User::where('email',$email)->first();
            if(isset($check_email))
            {
                return 'false';
            }
            else
            {
                return 'true';
            }
        }

    }

    // remote validation function to validate driver mobile number
    public function validateDriverMobileNUmber(Request $request)
    {
        $mobile_no = $request->user_mobile;
        $user_type = $request->type;
        if(isset($mobile_no))
        {
            $check_mobile = User::where('username',$mobile_no)->first();
            if(isset($check_mobile))
            {
                return 'false';
            }
            else
            {
                return 'true';
            }
        }
    }


    public function updateDriverMobileValidation(Request $request)
    {
        $mobile_no = $request->user_mobile;
        $id = $request->id;
        if(isset($mobile_no) && isset($id))
        {
            $update_mobile_number_check = UserInformation::where('user_mobile',$mobile_no)->where('user_id','<>',$id)->first();
            if(isset($update_mobile_number_check))
            {
                return 'false';
            }
            else
            {
                return 'true';
            }
        }
    }


    public function updateDriverEmailVAlidation(Request $request)
    {
        $email_id = $request->email;
        $id = $request->id;
        if(isset($email_id) && isset($id))
        {
            $update_email_check = User::where('email',$email_id)->where('id','<>',$id)->first();
            if(isset($update_email_check))
            {
                return 'false';
            }
            else
            {
                return 'true';
            }
        }
    }


    public function updateDriverProfile(Request $request)
    {
        $find_user_record = User::find($request->id);
        if(isset($find_user_record))
        {

            $find_user_record->email = $request->email;
            if(isset($request->new_password))
            {
                $find_user_record->password = $request->new_password;
            }
            if(isset($request->user_mobile))
            {
                $old_mobile_number = $find_user_record->userInformation->user_mobile;
                $find_user_record->username = $request->user_mobile;
                $find_user_record->userInformation->user_mobile = $request->user_mobile;
                $find_user_record->userInformation->alternate_number = $old_mobile_number;
            }

            if($request->hasFile('profile_picture'))
            {
                $old_image = $find_user_record->userInformation->profile_picture;
                $uploaded_file = $request->file('profile_picture');
                $extension = $uploaded_file->getClientOriginalExtension();
                $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
                \Storage::put('public/user-image/'.$new_file_name,file_get_contents($uploaded_file->getRealPath()));
                $find_user_record->userInformation->profile_picture = $new_file_name;
                if(isset($old_image) && $old_image != '')
                {

                    if(file_exists(storage_path('app/public/user-image/'.$old_image)))
                    {
                        unlink(storage_path('app/public/user-image/'.$old_image));
                    }
                }

            }
            $find_user_record->userInformation->first_name = $request->first_name;
            $find_user_record->userInformation->last_name = $request->last_name;
            
            foreach($find_user_record->userAddress as $adress)
            {
                $adress->user_country = $request->user_country;
                $adress->user_state = $request->user_state;
                $adress->user_city = $request->user_city;
                $adress->save();

            }
            $find_user_record->save();
            $find_user_record->userInformation->save();
            
            $find_user_record->driverUserInformation->hub_id = $request->hub_id;
            $find_user_record->driverUserInformation->save();
            
            $result = array('status' => '0', 'icon' =>'success', 'msg' => 'Driver Profile updated Successfully');
            return json_encode($result);

        }
        else
        {
            $result = array('status' => '0', 'icon' =>'errro', 'msg' => 'Opps Something Went Wrong');
            return json_encode($result);
        }
    }

    public function uploadDriverDocument(Request $request)
    {
        $insert_document = new DriverDocumentInformation();
        $document_name = $request->driver_document_name;
        $user_id = $request->user_id;
        if(isset($request->driver_document_number_pancard))
        {
            $insert_document->document_number = $request->driver_document_number_pancard;
        }
        if(isset($request->driver_document_number_adhar))
        {
            $insert_document->document_number = $request->driver_document_number_adhar;
        }
        if(isset($request->driver_document_number_license))
        {
            $insert_document->document_number = $request->driver_document_number_license;
        }
        if(isset($request->driver_document_expire_date))
        {
            $insert_document->expiry_date = str_replace('/','-',$request->driver_document_expire_date);
        }
        $insert_document->document_id = $document_name;
        $insert_document->user_id = $user_id;
        $insert_document->status = '1';
        if($request->hasFile('driver_document_image'))
        {
            $uploaded_file = $request->file('driver_document_image');
            $extension = $uploaded_file->getClientOriginalExtension();
            $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
            \Storage::put('public/driver-doc/'.$new_file_name,file_get_contents($uploaded_file->getRealPath()));
            $insert_document->file = $new_file_name;
        }
        if($insert_document->save())
        {
            $result = array('status' => '0','msg' => 'Document Uploaded Successfully','icon' => 'success');
            return json_encode($result);
        }
        else
        {
            $result = array('status' => '1','msg' => 'Opps Something Went Wrong','icon' => 'error');
            return json_encode($result);
        }
    }


    public function getDriverDocument(Request $request)
    {
        $user_id = $request->id;
        if(isset($user_id))
        {
            if(isset($user_id))
            {
                $agent_documents = DriverDocumentInformation::where('user_id',$user_id)->get();
                if(isset($agent_documents) && $agent_documents->count() > 0)
                {
                    $agent_doc_arr = [];
                    foreach($agent_documents as $index => $document)
                    {
                        if($document->document_id == '1')
                        {
                            $adhar_number = str_replace(' ', '', $document->document_number);
                            $temp_adhar_number = chunk_split($adhar_number,4," ");
                            $adhar_number = substr($temp_adhar_number, 0, -1);
                            $agent_doc_arr[$index]['document_number'] = $adhar_number;
                        }
                        else
                        {
                            $agent_doc_arr[$index]['document_number'] = $document->document_number;
                        }
                        $agent_doc_arr[$index]['id'] = $document->id;
                        $agent_doc_arr[$index]['document_name'] = $document->document->document_name;
                        $agent_doc_arr[$index]['expiry_date'] = isset($document->expiry_date) ? $document->expiry_date : 'N/A';
                        $agent_doc_arr[$index]['file'] = $document->file;
                        $agent_doc_arr[$index]['status'] = $document->status;

                    }
                    $result = array('status' => '0','data' => $agent_doc_arr);
                    return json_encode($result);
                }
                else
                {
                    $result = array('status' => '1');
                    return json_encode($result);
                }
            }
        }
    }

    public function downloadDocument($file)
    {
        $file_name = $file;
        $file_path = url('/storage/app/public/driver-doc/'.$file_name);
        return Storage::download($file_path);
    }

    public function getBankDetail(Request $request)
    {
        $user_id = $request->user_id;
        $all_banks = BankDetail::translatedIn(\App::getLocale())->where('status', '1')->get()->toArray();
        $driverBankDetails = UserBankDetail::where('user_id', $user_id)->first();
        $bank_detail_arr = [];
        if(isset($driverBankDetails))
        {
            $bank_detail_arr['branch_name'] = $driverBankDetails->branch_name;
            $bank_detail_arr['branch_code'] = $driverBankDetails->branch_code;
            $bank_detail_arr['bank_detail_id'] = $driverBankDetails->bank_detail_id;
            $account_number = '';
            if(isset($driverBankDetails->account_number))
            {
                //$delivery_controller = new \App\Http\Controllers\DeliveryController();
                //$account_number = explode("_etrio", $delivery_controller->decrypt($driverBankDetails->account_number, '_etriosecretkeyinkwxiihvpaqxwyh'));
                $account_number = base64_decode($driverBankDetails->account_number);
                $bank_detail_arr['account_number'] = $account_number;
            }
        }
        $result = array('status' => '0','banks' => $all_banks,'driver_bank_detail' =>$bank_detail_arr);
        return json_encode($result);
    }

    public function driverPaymentMethod(Request $request)
    {
        $user_id = $request->user_id;
        $create_count = 0;
        $update_count = 0;
        $user_pay_methods = UserPaymentMethod::where('user_id', $user_id)->count();
        if($user_pay_methods > 0)
        {
            UserPaymentMethod::where('user_id', $user_id)->delete();
        }
        //$deliver_controller = new DeliveryController();
        $userOtherInfo = DriverUserInformation::where('user_id', $user_id)->first();
        if(isset($userOtherInfo))
        {
            $update_count = 1;
            $userOtherInfo->bank_name = $request->bank_name;
            $userOtherInfo->ifsc_code = $request->ifsc_code;
            $userOtherInfo->branch_name = $request->branch_name;
            $acc_number = '';
            $account_number = isset($request->account_number) && $request->account_number != '' ? $request->account_number : '';
            if ($account_number != '') {
                //$acc_number = $deliver_controller->encrypt($account_number . "_etriosecretkeyinkwxiihvpaqxwyh");
                $acc_number = base64_encode($account_number);
            }
            $userOtherInfo->account_number = $acc_number;
            $userOtherInfo->save();
        }
        else
        {
            $create_count = 1;
            $createUserOtherInfo = new DriverUserInformation();
            $createUserOtherInfo->user_id = $user_id;
            $createUserOtherInfo->bank_name = $request->bank_name;
            $createUserOtherInfo->ifsc_code = $request->ifsc_code;
            $createUserOtherInfo->branch_name = $request->branch_name;
            $acc_number = '';
            $account_number = isset($request->account_number) && $request->account_number != '' ? $request->account_number : '';
            if ($account_number != '') {
                //$acc_number = $deliver_controller->encrypt($account_number . "_etriosecretkeyinkwxiihvpaqxwyh");
                $acc_number = base64_encode($account_number);
            }
            $createUserOtherInfo->account_number = $acc_number;
            $createUserOtherInfo->save();

        }
        $userBankDetails = UserBankDetail::where('user_id', $user_id)->first();
        if(isset($userBankDetails))
        {
            $update_count = 1;
            $userBankDetails->bank_detail_id = $request->bank_name;
            $userBankDetails->branch_code = $request->ifsc_code;
            $userBankDetails->branch_name = $request->branch_name;
            $acc_number = '';
            $account_number = isset($request->account_number) && $request->account_number != '' ? $request->account_number : '';
            if ($account_number != '') {
                //$acc_number = $deliver_controller->encrypt($account_number . "_etriosecretkeyinkwxiihvpaqxwyh");
                $acc_number = base64_encode($account_number);
            }
            $userBankDetails->account_number = $acc_number;
            $userBankDetails->save();
        }
        else
        {
            $create_count = 1;
            $createUserBankDetail = new UserBankDetail();
            $createUserBankDetail->user_id = $user_id;
            $createUserBankDetail->bank_detail_id = $request->bank_name;
            $createUserBankDetail->branch_code = $request->ifsc_code;
            $createUserBankDetail->branch_name = $request->branch_name;
            $acc_number = '';
            $account_number = isset($request->account_number) && $request->account_number != '' ? $request->account_number : '';
            if ($account_number != '') {
                //$acc_number = $deliver_controller->encrypt($account_number . "_etriosecretkeyinkwxiihvpaqxwyh");
                $acc_number = base64_encode($account_number);
            }
            $createUserBankDetail->account_number = $acc_number;
            $createUserBankDetail->save();

        }
        if($create_count == 1)
        {
            $result = array('status' => '0','msg' => 'Bank detail added successfully');
            return json_encode($result);
        }
        else
        {
            $result = array('status' => '0','msg' => 'Bank detail updated successfully');
            return json_encode($result);
        }

    }


    public function changeDriverDocumentStatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        $update_doc_status = DriverDocumentInformation::find($id);
        if(isset($update_doc_status))
        {
            $update_doc_status->status = $status;
            if($update_doc_status->save())
            {
                $result = array('status' => '0','msg' => 'Document status updated','icon' => 'success');
                return json_encode($result);
            }
            else
            {
                $result = array('status' => '1','msg' => 'Opps Something Went Wrong','icon' => 'error');
                return json_encode($result);
            }
        }
    }

    public function editDriverDocument(Request $request)
    {
        $id = $request->id;
        $edit_document = DriverDocumentInformation::find($id);
        if(isset($edit_document))
        {
            if($edit_document->document_id == '1')
            {
                $adhar_number = str_replace(' ', '', $edit_document->document_number);
                $temp_adhar_number = chunk_split($adhar_number,4," ");
                $adhar_number = substr($temp_adhar_number, 0, -1);
                $edit_document->document_number = $adhar_number;
            }
            $result = array('status' => '0','msg' => 'Success','data'=>$edit_document);
            return json_encode($result);
        }
    }

    public function updateDriverDocument(Request $request)
    {
        $id = $request->doc_id;
        $update_document = DriverDocumentInformation::find($id);
        if(isset($update_document))
        {
            if(isset($request->driver_document_number_pancard))
            {
                $update_document->document_number = $request->driver_document_number_pancard;
            }
            if(isset($request->driver_document_number_adhar))
            {
                $update_document->document_number = $request->driver_document_number_adhar;
            }
            if(isset($request->driver_document_number_license))
            {
                $update_document->document_number = $request->driver_document_number_license;
            }
            if(isset($request->driver_document_expire_date))
            {
                $update_document->expiry_date = str_replace('/','-',$request->driver_document_expire_date);
            }
            $update_document->document_id = $request->driver_document_name;
            $update_document->user_id = $request->user_id;
            $update_document->status = '1';
            if($request->hasFile('driver_document_image'))
            {
                $old_image = $update_document->file;
                $uploaded_file = $request->file('driver_document_image');
                $extension = $uploaded_file->getClientOriginalExtension();
                $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
                \Storage::put('public/driver-doc/'.$new_file_name,file_get_contents($uploaded_file->getRealPath()));
                $update_document->file = $new_file_name;
                unlink(storage_path('app/public/driver-doc/'.$old_image));

            }
            if($update_document->save())
            {
                $result = array('status' => '0','msg' => 'Document Updated Successfully','icon' => 'success');
                return json_encode($result);
            }
            else
            {
                $result = array('status' => '1','msg' => 'Opps Something Went Wrong','icon' => 'error');
                return json_encode($result);
            }

        }
    }

    public function downloadDriverDocument($id)
    {
        $id = base64_decode($id);
        $document = DriverDocumentInformation::select('file')->find($id);
        $image = $document->file;
        $filepath = url('storage/app/public/driver-doc/'.$image);
        $file = $image;
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.$file);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        ob_clean();
        flush();
        readfile($filepath);
        exit;

    }


 
}