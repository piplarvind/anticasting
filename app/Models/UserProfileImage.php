<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserProfileImage extends Model
{
    use HasFactory;
    protected $table = "user_profiles_image";
    protected $fillable = ['profile_images','user_id'];

}
