<?php

namespace Piplmodules\Roles\Models;

use Illuminate\Database\Eloquent\Model;
use Lang;

class Role extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    protected $hidden = ['created_by', 'updated_by'];
    protected $with = ['trans', 'hasPermission'];
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Trans relation.
     *
     * 
     */
    public function trans()
    {
        return $this->hasOne('\Piplmodules\Roles\Models\RoleTrans', 'role_id')->where('lang', '=', Lang::getlocale());
    }

    /**
     * Author relation.
     */
    public function author()
    {
        return $this->belongsTo('Piplmodules\Users\Models\User', 'created_by')->select(['id', 'name']);
    }

    /**
     * Get author attribute
     */
    //    public function getlastUpdateByAttribute()
    // {
    //     return $this->lastUpdateBy();
    // }

    /**
     * lastUpdateBy relation.
     */
    public function lastUpdateBy()
    {
        return $this->belongsTo('Piplmodules\Users\Models\User', 'updated_by')->select(['id', 'name']);
    }

    public function hasPermission()
    {
        return $this->hasMany('Piplmodules\Users\Models\PermissionRole', 'role_id')->orderBy('id','ASC');
    }

    public function scopeFilterName($query)
    {
        $getName = '';
        if(isset($_GET['name']) && !empty($_GET['name'])){
            $getName = $_GET['name'];
            return $query->whereHas('trans', function($q) use ($getName){
                $q->where('name', 'LIKE', '%'.$getName.'%');
            });
        }
    }

    /**
     * Scope a query to only include filterd activities status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterStatus($query)
    {
        $getStatus = '';
        if(isset($_GET['status']) && !empty($_GET['status'])){
            $getStatus = $_GET['status'];
            if($getStatus == 2){
                $getStatus = false;
            }
            return $query->where('active', $getStatus);
        }
    }
}
