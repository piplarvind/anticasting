<?php

namespace Piplmodules\Roles\Models;

use Illuminate\Database\Eloquent\Model;
use Lang;

class RoleTrans extends Model
{
    protected $table = 'roles_trans';


    /*protected $rules = [
        'name' => 'sometimes|required|email|unique:roles_trans',
    ];*/
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['role_id'];
}
