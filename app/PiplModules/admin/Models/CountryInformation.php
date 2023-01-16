<?php

namespace App\PiplModules\admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CountryInformation
 * @package App\PiplModules\admin\Models
 */
class CountryInformation extends Model
{
    public $translatedAttributes = ['name'];
    protected $fillable =['country_id','service_id','fixed_fees','ride_starting_fees','ride_driving_rate'];
}
