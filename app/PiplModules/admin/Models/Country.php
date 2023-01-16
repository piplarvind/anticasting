<?php

namespace App\PiplModules\admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
 * @package App\PiplModules\admin\Models
 */
class Country extends Model
{

    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    protected $fillable = ['name','time_zone','cancellation_charge', 'iso', 'country_code', 'currency_code', 'max_mobile_digit', 'payment_gateway'];

    /**
     * @description This function is used to get state information by using hasMany relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statesInfo()
    {
        return $this->hasMany('App\PiplModules\admin\Models\State');
    }

    /**
     * @description This function is used to get city information by using hasMany relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cityInfo()
    {
        return $this->hasMany('App\PiplModules\admin\Models\City');
    }

    /**
     * @description This function is used to get country service information by using hasMany relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function countryServices()
    {
        return $this->hasMany('App\PiplModules\admin\Models\CountryServices');
    }

    /**
     * @description This function is used to get city information by using hasManyThrough relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function citiesInfo()
    {
        return $this->hasManyThrough(City::class, State::class);
    }
}
