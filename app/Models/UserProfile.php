<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    protected $table = "user_profiles";
    protected $fillable = [

      'ethnicity',
      'date_of_birth',
      'gender',
      'contact',
      'current_location',
      'choose_language',
      'profile_image',
      'user_id',
      'email',

    ];
}
