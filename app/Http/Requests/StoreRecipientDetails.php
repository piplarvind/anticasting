<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\UserActivityDetails;

class StoreRecipientDetails extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /** 
         * By default it returns false, change it to 
         * something like this if u are checking authentication
         */
        return Auth::check();

        /** 
         * You could also use something more granular, like
         * a policy rule or an admin validation like this:
         * return auth()->user()->isAdmin();
         * 
         * Or just return true if you handle the authorization
         * anywhere else:
         * return true;
         */ 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $min = 14;
        $user_id = Auth::user()->id;
        $user_activity_details = UserActivityDetails::where(['user_id' => $user_id])->first();
        
        if (isset($user_activity_details) && $user_activity_details->receive_country == 'MEX' && explode("###", $user_activity_details->payment_method)[0] == 'BankAccount') {
            $min = 18;
        }
        if (session('payment_method') == 'BankAccount'){
            return [
                'bank_account_no' => 'required|min:'.$min,
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'phone_no' => 'required|numeric',
                'email' => 'nullable|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
                'city' => 'required|string',
                'address' => 'required',
                'state' => 'required|string',
                'reason_for_sending' => 'required',
            ];
        }else {
            return [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'phone_no' => 'required|min:10|numeric',
                'email' => 'nullable|email',
                'city' => 'required|string',
                'address' => 'required',
                'state' => 'nullable|string',
                'reason_for_sending' => 'required',
            ];
        }
        
    }

    public function messages()
    {
        $min = 14;
        $user_id = Auth::user()->id;
        $user_activity_details = UserActivityDetails::where(['user_id' => $user_id])->first();
        
        if (isset($user_activity_details) && $user_activity_details->receive_country == 'MEX' && explode("###", $user_activity_details->payment_method)[0] == 'BankAccount') {
            $min = 18;
        }
        return [
            'bank_account_no.required' => 'Please enter bank account number',
            'bank_account_no.min' => 'Please enter minimum '.$min.' characters',
            'first_name.required' => 'Please enter first name',
            'last_name.required' => 'Please enter last name',
            'phone_no.required' => 'Please enter phone number',
            'email.required' => 'Please enter email',
            'email.email' => 'Please enter valid email',
            'city.required' => 'Please enter city',
            'address.required' => 'Please enter address',
            'state.required' => 'Please enter state',
            'reason_for_sending.required' => 'Please select reason for sending',
        ];
    }
}
