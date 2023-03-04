<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntroVideo extends Model
{
    use HasFactory;
    protected $table = 'intro_videos';
    protected $fillable=['hindi_video','english_video','user_id'];
}
