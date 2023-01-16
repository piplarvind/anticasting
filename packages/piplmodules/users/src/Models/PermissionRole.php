<?php

namespace Piplmodules\Users\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permission_role';

    protected $with = ['getPermission'];

    /**
     * role relation.
     *
     * 
     */
    /*public function role()
    {
        return $this->belongsTo('Piplmodules\Roles\Models\Role', 'role_id');
    }*/

    public function getPermission()
    {
        return $this->belongsTo('Piplmodules\Permissions\Models\Permission','permission_id');
    }
}
