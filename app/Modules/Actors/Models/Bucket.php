<?php

namespace App\Modules\Actors\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bucket extends Model
{
    use HasFactory;
    protected $table = "buckets";
    protected $fillable = ['bucket_name','movie_name','movie_link','description','status'];
}
