<?php

namespace Piplmodules\Media\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

     /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
    ];

   /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function getThumbnailAttribute()
    {
    	$options = json_decode($this->attributes['options']);
        return $options->styles->thumbnail;
    }
}