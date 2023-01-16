<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreMobileShare extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            'refer_mobile_no' => 'required|digits:10|numeric'
        ];
        
    }

    public function messages()
    {
        return [
            'refer_mobile_no.required' => 'Please enter mobile number',
            'refer_mobile_no.digits' => 'Please enter 10 digits mobile number',
            'refer_mobile_no.numeric' => 'Please enter valid mobile number'
        ];
    }
}
