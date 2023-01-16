<?php

namespace Piplmodules\Permissions\Models;

use Illuminate\Database\Eloquent\Model;
use Lang;

class Permission extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    protected $with = ['trans'];
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
        return $this->hasOne('\Piplmodules\Permissions\Models\PermissionTrans', 'permission_id')->where('lang', '=', Lang::getlocale());
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
