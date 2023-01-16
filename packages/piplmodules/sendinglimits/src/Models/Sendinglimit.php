<?php

namespace Piplmodules\Sendinglimits\Models;

use Illuminate\Database\Eloquent\Model;
use Lang;

class Sendinglimit extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sending_limits';

    protected $with = ['attrs'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Translation relation.
     *
     */
    public function attrs()
    {
        return $this->hasOne(\Piplmodules\Sendinglimits\Models\SendingLimitAttribute::class, 'sending_limit_id')
        ->select('*');
    }

    /**
     * Scope a query to only include filterd topics name and status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeFilterName($query)
    {
        $getName = '';
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $getName = $_GET['name'];
            return $query->where('name', 'LIKE', '%'.$getName.'%');
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
