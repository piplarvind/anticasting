<?php

namespace Piplmodules\Permissions\Models;

use Illuminate\Database\Eloquent\Model;
use Lang;

class PermissionTrans extends Model
{
    protected $table = 'permissions_trans';
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['permission_id'];
}
