<?php

namespace Piplmodules\Faq\Models;

use Illuminate\Database\Eloquent\Model;
use Lang;

class Faq extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'faqs';

    protected $fillable = ['question', 'answer'];

    /**
     * Scope a query to only include filterd topics name and status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeFilterQuestion($query)
    {
        $getQuestion = '';
        if(isset($_GET['question']) && !empty($_GET['question'])){
            $getQuestion = $_GET['question'];
            return $query->where('question', 'LIKE', '%'.$getQuestion.'%');
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
