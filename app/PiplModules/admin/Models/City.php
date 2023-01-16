<?php

namespace App\PiplModules\admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class City
 * @package App\PiplModules\admin\Models
 */
class City extends Model {

    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    protected $fillable = ['name', 'support_number', 'state_id', 'country_id','status'];

    /**
     * @description This function is used to get state information by using belongsTo relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state() {
        return $this->belongsTo('App\PiplModules\admin\Models\State');
    }

    /**
     * @description This function is used to get country information by using belongsTo relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country() {
        return $this->belongsTo('App\PiplModules\admin\Models\Country');
    }

    public function HubInfo() {
        return $this->hasMany('App\PiplModules\hub\Models\Hub', 'id', 'city_id');
    }

}
