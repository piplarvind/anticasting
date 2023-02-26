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

    public function scopeFilterAge($query)
    {
        if (isset($_GET['max_age']) && !empty($_GET['max_age']) && isset($_GET['min_age']) && !empty($_GET['min_age'])) {
            $maxAge = (int)$_GET['max_age'];
            $minAge = (int)$_GET['min_age'];
            // prepare dates for comparison
            // make sure to use Carbon\Carbon in the
            // $dateOfBirth = '1990-08-17';
            // $years = \Carbon\Carbon::parse($dateOfBirth)->age;
           //  dd($years);
            $minDate = \Carbon\Carbon::today()->subYears($maxAge);
            $maxDate = \Carbon\Carbon::today()->subYears($minAge)->endOfDay();
            $query->whereBetween('date_of_birth', [$minDate,$maxDate]);
            // $query->where('ethnicity', 'like', '%'.$queryString.'%');
            // $query->whereHas('user', function ($q) use ($queryString) {
            //$q->where('name', 'like', '%' . $queryString . '%');
            // });
        }
    }

    public function scopeFilterHeight($query)
    {
        if (isset($_GET['max_height']) && !empty($_GET['max_height']) && isset($_GET['min_height']) && !empty($_GET['min_height'])) {
            $maxHeight = (int) $_GET['max_height'];
            $minHeight = (int) $_GET['min_height'];
         // dd($maxHeight);
            $query->whereBetween('height', [$minHeight,$maxHeight]);
        }
    }
    // public function scopeFilterStatus($query)
    // {
    //     if (isset($_GET['status']) && !empty($_GET['status'])) {
    //         if ($_GET['status'] == 1) {
    //             $status = 1;
    //         } else {
    //             $status = 0;
    //         }
    //         $query->where('status', $status);
    //     }
    // }
}
