<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserSenderDetails
 * @package App
 */
class UserSenderDetails extends Model
{

    protected $table ="user_sender_details";

    protected $fillable = ['user_id', 'first_name','last_name', 'country_code', 'phone_no', 'address_line_1','address_line_2', 'city','state','zip_code', 'dob'];

    
}
