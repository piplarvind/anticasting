<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreSendReceiveDetails extends FormRequest
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
        return Auth::check(); // <------------------

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
        
        return [
            'send_amount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'receive_amount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'payment_method' => 'required',
            'bank_name' => 'required'
        ];
        
    }

    public function messages()
    {
        return [
            'send_amount.required' => 'Please enter send amount',
            'receive_amount.required' => 'Please enter send amount',
            'payment_method.required' => 'Please select send & receive details',
            'bank_name.required' => 'Please select delivery location',
        ];
    }
}
