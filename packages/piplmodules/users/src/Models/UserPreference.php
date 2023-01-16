<?php

namespace Piplmodules\Users\Models;

use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_preferences';

    public function getPermission()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
