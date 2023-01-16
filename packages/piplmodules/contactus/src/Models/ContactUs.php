<?php 

namespace Piplmodules\Contactus\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $table='contact_us';

    protected $with = ['replies'];

    public function replies()
    {
        return $this->hasOne('\Piplmodules\Contactus\Models\ContactusReply', 'contact_id');
    }

    /**
     * Scope a query to only include filterd ads name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterName($query)
    {
        $getName = '';
        if(isset($_GET['name']) && !empty($_GET['name'])){
            $getName = $_GET['name'];
            return $query->whereHas('trans', function($q) use ($getName){
                $q->where('name', 'LIKE', '%'.$getName.'%');
            });
        }
    }

    /**
     * Scope a query to only include filterd ads status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterStatus($query)
     {
         $getStatus = '';
         //dd($_GET['status']);
         if(isset($_GET['status']) && !empty($_GET['status'])){
             $getStatus = $_GET['status'];
             if($getStatus == 2){
                 $getStatus = false;
             }
             return $query->where('is_read', $getStatus);
         }
     }


}