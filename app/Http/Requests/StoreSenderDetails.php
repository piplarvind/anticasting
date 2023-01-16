<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StoreSenderDetails extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone_no' => 'required|min:10|numeric',
            'address_line_1' => 'required',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|postal_code:US',
            'dob' => ['required',
            //'date_format:m/d/y',
            'before:' . Carbon::now()->subYears(18)->format('m/d/y')]
        ];
        
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Please enter first name',
            'last_name.required' => 'Please enter last name',
            'phone_no.required' => 'Please enter phone number',
            'address_line_1.required' => 'Please enter street address line 1',
            'state.required' => 'Please enter city',
            'state.required' => 'Please enter state',
            'zip_code.required' => 'Please enter zip code',
            'zip_code.postal_code' => 'Please enter valid zip code',
            'dob.required' => 'Please select date of birth'
        ];
    }
}
