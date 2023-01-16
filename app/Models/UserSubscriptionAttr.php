<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserSubscriptionAttr
 * @package App
 */
class UserSubscriptionAttr extends Model
{

    protected $table ="user_subscription_attrs";

    protected $fillable = ['user_id', 'user_subscription_id','one_day', 'one_day_price', 'thirty_day', 'thirty_day_price', 'half_yearly', 'half_yearly_price'];

    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    
}
