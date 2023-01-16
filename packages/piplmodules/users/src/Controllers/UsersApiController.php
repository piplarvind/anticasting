<?php

namespace Piplmodules\Users\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Piplmodules\Users\Models\User;
use Piplmodules\Users\Models\UserRole;
use Response;
use Auth;
use Illuminate\Support\Facades\Lang;
use Validator;
use App\Models\UserInformation;
use App\Models\UserRecipientDetails;

class UsersApiController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Piplmodules Users API Controller
      |--------------------------------------------------------------------------
      |
     */

    /**
     *
     *
     * @param
     * @return
     */
    public function storeValidation($request) {

        $languages = config('piplmodules.locales');
        $rules['first_name'] = 'required';
        $rules['last_name'] = 'required';
        $rules['email'] = 'required|email|unique:users';   // Unique
        $rules['mobile_number'] = 'required|numeric|min:10';
        $rules['password'] = 'required|min:8|confirmed';
        $rules['password_confirmation'] = 'required';

        return \Validator::make($request->all(), $rules);
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function updateValidation($request,$user_id)
    {

        $languages = config('piplmodules.locales');
        $rules['first_name'] = 'required';
        $rules['last_name'] = 'required';
        $rules['email'] = 'required|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users,email,'.$user_id;
        $rules['mobile_number'] = 'required|numeric|unique:users,mobile_number,'.$user_id;
        $rules['password'] = 'nullable|confirmed|min:8';
        return \Validator::make($request->all(), $rules);
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function listUsers(Request $request) {
        $users = User::where('user_type', '2')
            ->FilterName()
            ->FilterStatus()
            ->orderBy('id', 'DESC')
            ->paginate($request->get('paginate'));
        $users->appends($request->except('page'));
        return $users;
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function storeUser(Request $request) {
        $validator = $this->storeValidation($request);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
//        $user->gender = $request->gender;
//        $user->country_code = $request->iso2;
        $user->mobile_number = $request->mobile_number;
        $user->country_code = $request->mobile_number_phoneCode;
        $user->user_type = '2';
        $user->password = bcrypt($request->password);
        $user->account_status = '0';
        if ($request->account_status == '1') {
            $user->account_status = '1';
            $user->email_verified = true;
        }

        // Media
        /*$options['media']['main_image_id'] = $request->main_image_id;
        $user->options = $options;*/

        $user->save();

        // User role
        $userRole = new UserRole;
        $userRole->user_id = $user->id;
//        $userRole->role_id = $request->get('role_id');
        $userRole->role_id = 3;
        $userRole->save();

        $response = ['message' => trans('Core::operations.saved_successfully')];
        return response()->json($response, 201);
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function updateUser(Request $request, $id) {
//        dd($request->old_user_email);
        $validator = $this->updateValidation($request,$id);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }



        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
//        $user->gender = $request->gender;
//        $user->country_code = $request->iso2;
        $user->mobile_number = $request->mobile_number;
        $user->country_code = $request->mobile_number_phoneCode;
        $user->user_type = '2';
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->account_status = '0';
        if ($request->account_status == '1') {
            $user->account_status = '1';
            $user->email_verified = true;
        }

        // Media
        /*$options['media']['main_image_id'] = $request->main_image_id;
        $user->options = $options;*/

        $user->save();

        //set User Role
        /*$userRole = UserRole::where('user_id', $user->id)->first();
        $userRole->user_id = $user->id;
        $userRole->role_id = 3;
        $userRole->save();*/
        $response = ['message' => trans('Core::operations.updated_successfully')];
        return response()->json($response, 201);
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function updateAddressValidation($request,$user_id)
    {

        $languages = config('piplmodules.locales');
        $rules['address_line_1'] = 'required';
        $rules['city'] = 'required';
        $rules['state'] = 'required';
        $rules['zip_code'] = 'required';
        return \Validator::make($request->all(), $rules);
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function updateSendCountryValidation($request)
    {

        $rules['send_money_to'] = 'required';
        return \Validator::make($request->all(), $rules);
    }

    /**
     *
     * @param
     * @return
     */
    public function updateUserAddress(Request $request, $id) {
        
        $validator = $this->updateAddressValidation($request,$id);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }       

        $userInfo = UserInformation::where('user_id',$id)->first();
        $userInfo->address_line_1 = $request->address_line_1;
        $userInfo->city = $request->city;
        $userInfo->state = $request->state;
        $userInfo->zip_code = $request->zip_code;
        $userInfo->save();
        
        $response = ['message' => trans('Core::operations.updated_successfully')];
        return response()->json($response, 201);
    }

    /**
     *
     * @param
     * @return
     */
    public function updateSendCountry(Request $request, $id) {
        
        $validator = $this->updateSendCountryValidation($request);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }       

        $userInfo = UserInformation::where('user_id',$id)->first();
        $userInfo->send_money_to = $request->send_money_to;        
        $userInfo->save();
        
        $response = ['message' => trans('Core::operations.updated_successfully')];
        return response()->json($response, 201);
    }

    /**
     *
     * @param
     * @return
     */
    public function listRecipients(Request $request, $user_id) {
        $recipients = UserRecipientDetails::where('user_id', $user_id)
            ->orderBy('id', 'DESC')
            ->paginate($request->get('paginate'));
        $recipients->appends($request->except('page'));
        return $recipients;
    }

    /**
     *
     * @param
     * @return
     */
    public function recipientDetails(Request $request, $id) {
        $recipients = UserRecipientDetails::findOrFail($id);
        return $recipients;
    }

    /**
     *
     * @param
     * @return
     */
    public function recipientDelete($id) {
        $recipient = UserRecipientDetails::findOrFail($id);
        if($recipient){
            $recipient->delete();
            return true;
        }else{
            return false;
        }
    }

}
