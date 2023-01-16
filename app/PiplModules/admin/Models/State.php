<?php
namespace App\PiplModules\admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class State
 * @package App\PiplModules\admin\Models
 */
class State extends Model 
{
    use \Dimsav\Translatable\Translatable;
    public $translatedAttributes = ['name'];
    protected $fillable = ['name','country_id','status'];

    /**
     * @description This function is used to get country information by using belongsTo relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
            return $this->belongsTo('App\PiplModules\admin\Models\Country');
    }

    /**
     * @description This function is used to get city information by using hasMany relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cityInfo()
    {
        return $this->hasMany('App\PiplModules\admin\Models\City');
    }
}