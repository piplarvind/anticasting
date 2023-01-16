<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Piplmodules\Users\Models\User;

/**
 * Class UserPaymentTransaction
 * @package App
 */
class UserPaymentTransaction extends Model
{

    protected $table ="user_payment_transaction";

    protected $fillable = ['user_id', 'transaction_id', 'fees', 'fees_currency', 'sent_amount', 'currency', 'receive_amount','receive_currency', 'status', 'transaction_request','transaction_response'];

    /**
     * Get related user
     */
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

}
