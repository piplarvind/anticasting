<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserActivityDetails
 * @package App
 */
class UserActivityDetails extends Model
{

    protected $table ="user_activity_details";

    protected $fillable = ['user_id','send_amount', 'receive_amount','payment_method','bank_name', 'step_to_complete'];

    
}
