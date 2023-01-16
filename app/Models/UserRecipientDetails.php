<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRecipientDetails
 * @package App
 */
class UserRecipientDetails extends Model
{

    protected $table ="user_recipient_details";

    protected $fillable = ['user_id','bank_account_no', 'first_name','last_name', 'country_code','phone_no', 'email', 'address', 'city','state','reason_for_sending'];

    
}
