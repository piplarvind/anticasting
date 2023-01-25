<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;
    protected $table = "users_otps";
    protected $fillable = [
        
        'mobile_code',
        'mobile_no',
        'otp',
        'expiry_date',
      
    ];
}
