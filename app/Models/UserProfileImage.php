<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfileImage extends Model
{
    use HasFactory;
    protected $table = "user_profiles_image";
    protected $fillable = ['profile_images','user_profile_id'];
}
