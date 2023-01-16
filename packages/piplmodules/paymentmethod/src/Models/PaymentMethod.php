<?php

namespace Piplmodules\PaymentMethod\Models;

use Illuminate\Database\Eloquent\Model;
use Lang;

class PaymentMethod extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payment_methods';

    protected $fillable = ['payment_method_name', 'slug', 'status'];

    /**
     * Scope a query to only include filterd topics name and status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeFilterPaymentMethodName($query)
    {
        $getPaymentMethodName = '';
        if(isset($_GET['payment_method_name']) && !empty($_GET['payment_method_name'])){
            $getPaymentMethodName = $_GET['payment_method_name'];
            return $query->where('payment_method_name', 'LIKE', '%'.$getPaymentMethodName.'%');
        }
    }

    public function scopeFilterStatus($query) {
        $getStatus = '';
        //dd($_GET['status']);
        if(isset($_GET['status']) && !empty($_GET['status'])){
            if($_GET['status'] == 1){
                $getStatus = $_GET['status'];
            }else{
                $getStatus = 0;
            }
            return $query->where('status', $getStatus);
        }
    }


}
