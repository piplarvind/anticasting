<?php

namespace Piplmodules\Users\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_roles';

    /**
     * The hidden data.
     *
     * @var string
     */
    protected $hidden = ['user_id', 'id'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * role relation.
     *
     * 
     */
    public function role()
    {
        return $this->belongsTo('Piplmodules\Roles\Models\Role', 'role_id', 'id');
    }
}
