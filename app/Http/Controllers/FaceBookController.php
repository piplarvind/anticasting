<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Helpers\GeneralHelper;
use App\Models\UserActivityDetails;
use Piplmodules\Sendinglimits\Models\Sendinglimit;
use App\Models\UserSubscription;
use App\Models\UserSubscriptionAttr;


class FaceBookController extends Controller
{
    /**
     * Login Using Facebook
     */
    public function loginUsingFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callbackFromFacebook(Request $request)
    {
        try {
            if(isset($request->error_code)){
                return redirect()->route('login')->with("alert-danger", $request->error_message);
            }
            Socialite::driver('facebook')->stateless()->user();
            $user = Socialite::driver('facebook')->user();

            $finduser = User::where('email', $user->email)->first();

            if(isset($finduser)){
                if ($finduser->account_status == '1') {
                    Auth::login($finduser);
                    
                    $user_activity = UserActivityDetails::where(['user_id' => $finduser->id])->first();
                    if(isset($user_activity)){
                        return redirect('dashboard');
                    }else{
                        return redirect('send-receive-details');
                    }
                    
                }elseif ($finduser->account_status == '0') {
                    $errorMsg = "We apologies, your account is inactive by administrator. Please contact to administrator for further details";
                } elseif ($finduser->account_status == '2') {
                    $errorMsg = "We apologies, your account is blocked by administrator. Please contact to administrator for further details";
                } elseif ($finduser->account_status == '3') {
                    $errorMsg = "We apologies, your account is suspended by administrator. Please contact to administrator for further details";
                }elseif ($finduser->account_status == '4') {
                    $errorMsg = "We apologies, your account is deleted by administrator. Please contact to administrator for further details";
                }
                Auth::logout();
                return redirect("login")->with("alert-danger", $errorMsg);
            }else{
                $userData = new User();
                $activation_code = GeneralHelper::generateReferenceNumber();

                $name = explode(" ", $user->name);
                $userData->name = $user->name;
                $userData->email = $user->email;
                $userData->activation_code = $activation_code;
                $userData->password = Hash::make($activation_code);
                if(is_array($name)){
                    $userData->first_name = $name[0];
                    $userData->last_name = $name[1];
                }                
                $userData->mobile_verified = 1;
                $userData->account_status = '1';
                $userData->email_verified = 1;
                $userData->user_type = '2';
                $userData->facebook_id = $user->id;
                $userData->save();

                \DB::table('users_roles')->insert([
                    'role_id' => 3,
                    'user_id'=> $userData->id
                ]);

                $user_info = new UserInformation();
                $user_info->user_id = $userData->id;
                $user_info->send_money_from = 'USA';//Default country to send money from country
                $user_info->send_money_to = 'MEX';//Default country to send money to country
                $user_info->referral_code = strtotime(date('Y-m-d H:i:s'));
                $user_info->friend_referral_code = ($request->referralCode)?$request->referralCode:null;
                $user_info->save();

                /**
                 * Assign the default sending limit to user
                 */
                $sendingLimit = Sendinglimit::where('id', 1)->first();

                if(isset($sendingLimit)){
                    $userSubscription = new UserSubscription();
                    $userSubscription->user_id = $user->id;
                    $userSubscription->sending_limit_name = $sendingLimit->name;
                    $userSubscription->save();

                    $userSubscriptionAttr = new UserSubscriptionAttr();
                    $userSubscriptionAttr->user_id = $user->id;
                    $userSubscriptionAttr->user_subscription_id = $userSubscription->id;
                    $userSubscriptionAttr->one_day_price = $sendingLimit->attrs->one_day_price;
                    $userSubscriptionAttr->thirty_day_price = $sendingLimit->attrs->thirty_day_price;
                    $userSubscriptionAttr->half_yearly_price = $sendingLimit->attrs->half_yearly_price;
                    $userSubscriptionAttr->save();
                }
                Auth::login($userData);
                //request()->session()->flash('alert-success', 'You have registered successfully, please edit your profile');
                //return redirect()->back(); edit-profile
                return redirect("edit-profile")->with("alert-success", 'You have registered successfully, please edit your profile');
            }
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }

    public function loginUsingGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackFromGoogle(Request $request)
    {
        try {

            Socialite::driver('google')->stateless()->user();
            $userInfo = Socialite::driver('google')->user();
            //dd($userInfo);
            //dd($userInfo->user['given_name']);
            $finduser = User::where('email', $userInfo->email)->first();

            if($finduser){

                if ($finduser->account_status == '1') {
                    Auth::login($finduser);
                    
                    $user_activity = UserActivityDetails::where(['user_id' => $userInfo->id])->first();
                    if(isset($user_activity)){
                        return redirect('dashboard');
                    }else{
                        return redirect('send-receive-details');
                    }
                    
                }elseif ($finduser->account_status == '0') {
                    $errorMsg = "We apologies, your account is inactive by administrator. Please contact to administrator for further details";
                } elseif ($finduser->account_status == '2') {
                    $errorMsg = "We apologies, your account is blocked by administrator. Please contact to administrator for further details";
                } elseif ($finduser->account_status == '3') {
                    $errorMsg = "We apologies, your account is suspended by administrator. Please contact to administrator for further details";
                }elseif ($finduser->account_status == '4') {
                    $errorMsg = "We apologies, your account is deleted by administrator. Please contact to administrator for further details";
                }
                Auth::logout();
                return redirect("login")->with("alert-danger", $errorMsg);

            }else{

                $user = new User();

                $activation_code = GeneralHelper::generateReferenceNumber();

                $user->name = $userInfo->name;
                $user->email = $userInfo->email;
                $user->activation_code = $activation_code;
                $user->password = Hash::make($activation_code);
                $user->first_name = $userInfo->name;
                $user->last_name = $userInfo->name;
                
                $user->mobile_verified = 1;
                $user->account_status = '1';
                $user->email_verified = 1;
                $user->user_type = '2';
                $user->google_id = $userInfo->id;
                $user->save();

                \DB::table('users_roles')->insert([
                    'role_id' => 3,
                    'user_id'=> $user->id
                ]);

                $user_info = new UserInformation();
                $user_info->user_id = $user->id;
                $user_info->send_money_from = 'USA';//Default country to send money from country
                $user_info->send_money_to = 'MEX';//Default country to send money to country
                $user_info->referral_code = strtotime(date('Y-m-d H:i:s'));
                $user_info->friend_referral_code = ($request->referralCode)?$request->referralCode:null;
                $user_info->save();

                /**
                 * Assign the default sending limit to user
                 */
                $sendingLimit = Sendinglimit::where('id', 1)->first();

                if(isset($sendingLimit)){
                    $userSubscription = new UserSubscription();
                    $userSubscription->user_id = $user->id;
                    $userSubscription->sending_limit_name = $sendingLimit->name;
                    $userSubscription->save();

                    $userSubscriptionAttr = new UserSubscriptionAttr();
                    $userSubscriptionAttr->user_id = $user->id;
                    $userSubscriptionAttr->user_subscription_id = $userSubscription->id;
                    $userSubscriptionAttr->one_day_price = $sendingLimit->attrs->one_day_price;
                    $userSubscriptionAttr->thirty_day_price = $sendingLimit->attrs->thirty_day_price;
                    $userSubscriptionAttr->half_yearly_price = $sendingLimit->attrs->half_yearly_price;
                    $userSubscriptionAttr->save();
                }

                Auth::login($user);
                //return redirect()->back();
                return redirect("edit-profile")->with("alert-success", 'You have registered successfully, please edit your profile');
            }

        } catch (Exception $e) {
            return redirect('google/auth');
        }
    }
}
