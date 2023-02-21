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
    protected $fillable = ['ethnicity', 'date_of_birth', 'gender', 'contact', 'current_location', 'choose_language', 'image', 'user_id', 'email', 'status',];
    // protected $with = ['profileImage'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->select(['first_name' => 'first_name','last_name'=>'last_name','mobile_no'=>'mobile_no','countryCode'=>'countryCode','email'=>'email']);
    }
    public function profileImage()
    {
        return $this->hasOne(UserProfileImage::class, 'user_id', 'user_id');
    }

    public function scopeFilterName($query)
    {
        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $queryString = $_GET['q'];
            // $query->where('ethnicity', 'like', '%'.$queryString.'%');
      $query->whereHas('user', function ($q) use ($queryString) {
        $q->where('name', 'like', '%' . $queryString . '%');
            });
        }
    }

    public function scopeFilterStatus($query)
    {
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            if ($_GET['status'] == 1) {
                $status = 1;
            } else {
                $status = 0;
            }
            $query->where('status', $status);
        }
    }
}
