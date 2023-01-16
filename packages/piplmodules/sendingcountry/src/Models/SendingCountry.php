<?php

namespace Piplmodules\SendingCountry\Models;

use Illuminate\Database\Eloquent\Model;
use Lang;

class SendingCountry extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sending_countries';

    protected $fillable = ['country_name', 'slug','country_iso_code', 'phone_code','currency' ,'flag', 'payment_methods', 'status'];

    /**
     * Scope a query to only include filterd topics name and status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeFilterCountryName($query)
    {
        $getCountryName = '';
        if(isset($_GET['country_name']) && !empty($_GET['country_name'])){
            $getCountryName = $_GET['country_name'];
            return $query->where('country_name', 'LIKE', '%'.$getCountryName.'%');
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
