<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\{UserProfileImage,UserProfile};

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
    public function scopeFilterName($query)
    {
        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $queryString = $_GET['q'];
          $query->where('name', 'like', '%'.$queryString.'%');
    //   $query->whereHas('user', function ($q) use ($queryString) {
    //     $q->where('name', 'like', '%' . $queryString . '%');
    //         });
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
    // public function scopeFilterEthnicity($query){
    //     $queryString = $_GET['ethnicity'];
    //    dd($queryString);
    // }
    
}
