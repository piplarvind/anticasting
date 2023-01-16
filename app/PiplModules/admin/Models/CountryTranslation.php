<?php
namespace App\PiplModules\admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent ;

/**
 * Class CountryTranslation
 * @package App\PiplModules\admin\Models
 */
class CountryTranslation extends Eloquent
{
   protected $fillable = array('name','support_number');
}