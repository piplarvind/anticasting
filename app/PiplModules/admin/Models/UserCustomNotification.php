<?php

namespace App\PiplModules\admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserCustomNotification
 * @package App\PiplModules\admin\Models
 */
class UserCustomNotification extends Model
{
    protected $fillable = ['user_id','type','sent_by','title', 'description'];

    /**
     * @description This function is used to get user information by using belongsTo relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sentMessageUserInfo()
    {
        return $this->belongsTO('App\User','user_id','id');
    }

}
