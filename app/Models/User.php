<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\{UserProfileImage,UserProfile,IntroVideo};

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     *
     */
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'first_name', 'last_name', 'date_of_birth', 'gender', 'user_type', 'mobile_no'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function images()
    {
        return $this->hasMany(UserProfileImage::class, 'user_id');
    }
    public function profile(){
        return $this->hasOne(UserProfile::class, 'user_id');
    }
    public function introVideo(){
       
        return $this->hasOne(IntroVideo::class, 'user_id');
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
            $query->whereHas('profile',function($q) use( $minDate, $maxDate){
                $q->whereBetween('date_of_birth', [$minDate,$maxDate]);
            });
            // $query->where('ethnicity', 'like', '%'.$queryString.'%');
            // $query->whereHas('user', function ($q) use ($queryString) {
            //$q->where('name', 'like', '%' . $queryString . '%');
            // });
        }
    }
    public function scopeFilterEthnicty($query){
        if (isset($_GET['ethnicity']) && !empty($_GET['ethnicity'])){
            $Ethnicty=  $_GET['ethnicity'];
           if(is_array( $Ethnicty)){
           return $query->whereHas('profile',function($q) use($Ethnicty){
                $q->whereIn('ethnicity', $Ethnicty);
            });
                //  return $query->when(count($Ethnicty), function ($query) use ($Ethnicty) {
                //     $query->whereIn('ethnicity', $Ethnicty);
                // });
           }
        }
       }
       public function scopeFilterGender($query){
        if (isset($_GET['gender']) && !empty($_GET['gender'])){
            $Gender =  $_GET['gender'];
            if(is_array($Gender)){
              return $query->whereHas('profile',function($q) use($Gender){
                    $q->whereIn('gender', $Gender);
                });
            }
        }
       }
    public function scopeFilterHeight($query)
    {
        if (isset($_GET['max_height']) && !empty($_GET['max_height']) && isset($_GET['min_height']) && !empty($_GET['min_height'])) {
            $maxHeight = (int) $_GET['max_height'];
            $minHeight = (int) $_GET['min_height'];
         // dd($maxHeight);
          $query->whereHas('profile',function($q) use( $minHeight,  $maxHeight){
            $q->whereBetween('height', [$minHeight,$maxHeight]);
          });
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
