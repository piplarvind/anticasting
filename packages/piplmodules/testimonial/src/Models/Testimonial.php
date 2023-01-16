<?php

namespace Piplmodules\Testimonial\Models;

use Illuminate\Database\Eloquent\Model;
use Lang;

class Testimonial extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'testimonials';

    protected $fillable = ['client_name', 'testimonial', 'rating', 'status', 'order'];

    /**
     * Scope a query to only include filterd topics name and status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeFilterClientName($query)
    {
        $getQuestion = '';
        if(isset($_GET['client_name']) && !empty($_GET['client_name'])){
            $getQuestion = $_GET['client_name'];
            return $query->where('client_name', 'LIKE', '%'.$getQuestion.'%');
        }
    }

    public function scopeFilterStatus($query) {
        $getStatus = '';
        //dd($_GET['status']);
        if(isset($_GET['status']) && !empty($_GET['status'])){
            if($_GET['status'] == 1){
                $getStatus = $_GET['status'];
            }else{
                $getStatus = 0;
            }
            return $query->where('status', $getStatus);
        }
    }
}
