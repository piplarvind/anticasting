<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserInformation
 * @package App
 */
class UserInformation extends Model
{

    protected $table ="user_informations";

    protected $fillable = ['address_line_1', 'address_line_1','dob', 'city','state', 'country', 'zip_code', 'send_money_from', 'send_money_to'];

    

    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    
}
