<?php

namespace Piplmodules\Pages\Models;

use Illuminate\Database\Eloquent\Model;
use Lang;

class PageTrans extends Model
{
    protected $table = 'pages_trans';
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['page_id'];
    protected $fillable = ['title', 'body','lang','page_seo_title','page_meta_keywords','page_meta_descriptions'];
}
