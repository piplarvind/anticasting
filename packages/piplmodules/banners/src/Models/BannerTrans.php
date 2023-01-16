<?php

namespace Piplmodules\Banners\Models;

use Illuminate\Database\Eloquent\Model;
use Lang;

class BannerTrans extends Model
{
    protected $table = 'banners_trans';
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['banner_id'];
}
