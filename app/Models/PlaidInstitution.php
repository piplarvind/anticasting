<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PlaidInstitution
 * @package App
 */
class PlaidInstitution extends Model
{

    protected $table ="plaid_institutions";

    protected $fillable = ['country_codes', 'institution_id','name', 'routing_numbers'];

    
}
