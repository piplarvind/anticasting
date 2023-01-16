<?php

namespace Piplmodules\Users\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Piplmodules\Users\Models\User;
use Piplmodules\Users\Models\UserRole;
use Illuminate\Support\Facades\Lang;

class AdminApiController extends Controller
{
    /**
     *
     *
     * @param
     * @return
     */
    public function userValidation($request)
    {

        $languages = config('piplmodules.locales');
        $rules['name'] = 'required|unique:users';
        $rules['role'] = 'required';
        $rules['email'] = 'required|email|unique:users';   // Unique

        $rules['mobile_number'] = 'required|numeric';
        $rules['password'] = 'required|min:6|confirmed';
        $rules['password_confirmation'] = 'required';

        return \Validator::make($request->all(), $rules);
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function updateValidation($request, $old_email = "", $old_phone = "")
    {
        $rules['first_name'] = 'required';
        $rules['last_name'] = 'required';
        // $rules['role'] = 'required';
        if ($old_email == $request->email)
            $rules['email'] = 'required|email';
        else
            $rules['email'] = 'required|email|unique:users';

        if ($old_phone == $request->mobile_number) {
            $rules['mobile_number'] = 'required';
        } else {
            //            $rules[ 'phone' ] = 'required|numeric|unique:users';
            $rules['mobile_number'] = 'required';
        }

        if ($request->segment(2) === 'api') {
            $rules['updatedBy'] = 'required|integer';
        }
        if (isset($request->password)) {
            $rules['password'] = 'required|confirmed';
            $rules['password_confirmation'] = 'required';
        }
        //        $rules['password'] = 'min:6|confirmed';
        //        $rules['password_confirmation'] = 'required';

        return \Validator::make($request->all(), $rules);
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function listUsers(Request $request)
    {
        $users = User::where('id', '!=', 10000)->FilterName()->FilterStatus()->FilterRole($request->get('role_id'))->orderBy('id', 'DESC')->paginate($request->get('paginate'));
        $users->appends($request->except('page'));
        return $users;
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function storeUser(Request $request)
    {
        $validator = $this->userValidation($request);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = new User;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        //        $user->gender = $request->gender;
        $user->mobile_number = $request->mobile_number;
        $user->country_code = $request->mobile_number_phoneCode;
        $user->password = bcrypt($request->password);
        $user->account_status = '0';
        if ($request->account_status == '1') {
            $user->account_status = '1';
            $user->email_verified = true;
        }
        $user->user_type = '1';
        // Media
        /*$options['media']['main_image_id'] = $request->main_image_id;
        $user->options = $options;*/
        $user->save();

        // User role
        $userRole = new UserRole;
        $userRole->user_id = $user->id;
        //        $userRole->role_id = $request->get('role_id');
        $userRole->role_id = $request->role;
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
    public function updateUser(Request $request, $id)
    {
        //        dd($request->old_user_email);
        $validator = $this->updateValidation($request, $request->old_user_email, $request->old_user_phone);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::find($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        //        $user->gender = $request->gender;
        //        $user->country_code = $request->iso2;
        $user->mobile_number = $request->mobile_number;
        $user->country_code = $request->mobile_number_phoneCode;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        // $user->account_status = '0';
        // if ($request->account_status == '1') {
        //     $user->account_status = '1';
        //     $user->email_verified = true;
        // }

        // Media
        /*$options['media']['main_image_id'] = $request->main_image_id;
        $user->options = $options;*/

        // $user->user_type = '1';
        $user->save();

        // User role
        // $userRole = UserRole::where('user_id', $user->id)->first();
        // $userRole->user_id = $user->id;
        // $userRole->role_id = $request->role;
        // $userRole->save();

        $response = ['message' => trans('Core::operations.updated_successfully')];
        return response()->json($response, 201);
    }
}
