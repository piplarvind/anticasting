<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePaymentDetails extends FormRequest
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
            'card_no' => 'nullable|numeric',
            'expiry_date' => 'nullable',
            'cvv' => 'nullable|numeric',
            'name_on_card' => 'nullable|string'
        ];
        
    }

    public function messages()
    {
        return [
            'card_no.required' => 'Please enter card number',
            'expiry_date.required' => 'Please enter expiry date',
            'cvv.required' => 'Please enter cvv',
            'name_on_card.required' => 'Please enter name as it appears on card'
        ];
    }
}
