<?php

namespace Piplmodules\Emailtemplates\Models;

use Illuminate\Database\Eloquent\Model;
use Lang;

class EmailTemplate extends Model {

    protected $table = 'email_templates';

    protected $hidden = ['created_by', 'updated_by'];

    protected $with = ['trans', 'author', 'lastUpdateBy'];

    public function trans()
    {
        return $this->hasOne('\Piplmodules\Emailtemplates\Models\EmailTemplateTrans', 'etemplate_id')->where('lang', Lang::getlocale());
    }

    /**
     * Author relation.
     */
    public function author()
    {
        return $this->belongsTo('Piplmodules\Users\Models\User', 'created_by')->select(['id', 'name']);
    }

    /**
     * Get author attribute
     */
    //    public function getlastUpdateByAttribute()
    // {
    //     return $this->lastUpdateBy();
    // }

    /**
     * lastUpdateBy relation.
     */
    public function lastUpdateBy()
    {
        return $this->belongsTo('Piplmodules\Users\Models\User', 'updated_by')->select(['id', 'name']);
    }
    public function scopeFilterStatus($query) {
        $getStatus = '';
        //dd($_GET['status']);
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            $getStatus = $_GET['status'];
            if ($getStatus == 2) {
                $getStatus = false;
            }
//            return $query->where('active', $getStatus);
            return $query->whereHas('trans', function($q) use ($getStatus){
                $q->where('status', $getStatus);
            });
        }
    }

}
