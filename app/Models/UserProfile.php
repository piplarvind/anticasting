<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserProfileImage;
use App\Models\User;
class UserProfile extends Model
{
    use HasFactory;
    protected $table = 'user_profiles';
    protected $fillable = ['ethnicity', 'date_of_birth', 'gender', 'contact', 'current_location', 'choose_language', 'image', 'user_id', 'email', 'status'];
    // protected $with = ['profileImage'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->select(['first_name' => 'first_name', 'last_name' => 'last_name', 'mobile_no' => 'mobile_no', 'countryCode' => 'countryCode', 'email' => 'email']);
    }
    public function profileImage()
    {
        return $this->hasMany(UserProfileImage::class, 'user_id', 'user_id');
    }
}
