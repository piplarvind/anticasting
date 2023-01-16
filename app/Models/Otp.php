<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserInformation
 * @package App
 */
class Otp extends Model
{

    protected $table ="user_otps";

    protected $fillable = ['mobile_code','mobile_no', 'otp','event_type', 'expiry_date'];

    
}
