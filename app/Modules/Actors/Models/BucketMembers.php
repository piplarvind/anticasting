<?php

namespace App\Modules\Actors\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BucketMembers extends Model
{
    use HasFactory;
    protected $table = "bucket_members";
    protected $fillable = ['user_id','bucket_id','status'];
}
