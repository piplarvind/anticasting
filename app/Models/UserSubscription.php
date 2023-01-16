<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserSubscription
 * @package App
 */
class UserSubscription extends Model
{

    protected $table ="user_subscriptions";

    protected $fillable = ['user_id', 'sending_limit_name'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }


}
