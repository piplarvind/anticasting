<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserPaymentDetails
 * @package App
 */
class UserPaymentDetails extends Model
{

    protected $table ="user_payment_details";

    protected $fillable = ['user_id', 'card_no','expiry_date', 'cvv', 'name_on_card'];

    
}
