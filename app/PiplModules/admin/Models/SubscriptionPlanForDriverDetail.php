<?php
namespace App\PiplModules\admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SubscriptionPlanForDriverDetail
 * @package App\PiplModules\admin\Models
 */
class SubscriptionPlanForDriverDetail extends Model
{

    protected $fillable = ['subscription_plan_detail_id','driver_id','expiry_date','status','start_date'];

    /**
     * @description This function is used to get user information by using hasOne relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userInfo()
    {
        return $this->hasOne('App\UserInformation', 'user_id', 'driver_id');
    }

    /**
     * @description This function is used to get service plan information by using hasOne relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subscriptionplan()
    {
        return $this->hasOne('App\PiplModules\serviceplan\Models\SubscriptionPlan', 'id', 'subscription_plan_detail_id');
    }

    /**
     * @description This function is used to get subscription plan details by using hasOne relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subscriptionplandetail()
    {
        return $this->hasOne('App\PiplModules\serviceplan\Models\SubscriptionPlanDetail', 'id', 'subscription_plan_detail_id');
    }

}
