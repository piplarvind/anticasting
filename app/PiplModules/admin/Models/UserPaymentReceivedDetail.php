<?php

namespace App\PiplModules\admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserPaymentReceivedDetail
 * @package App\PiplModules\admin\Models
 */
class UserPaymentReceivedDetail extends Model
{
    protected $fillable = ['user_id','paid_by','bank_name', 'cheque_number', 'transaction_number', 'payment_mode', 'branch_name', 'amount'];

    /**
     * @description This function is used to get user information by using belongsTo relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paidUserInfo()
    {
        return $this->belongsTO('App\User','user_id','id');
    }

}
