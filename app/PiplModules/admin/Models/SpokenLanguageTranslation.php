<?php
namespace App\PiplModules\admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent ;

/**
 * Class SpokenLanguageTranslation
 * @package App\PiplModules\admin\Models
 */
class SpokenLanguageTranslation extends Eloquent
{
    protected $fillable = array('name','spoken_language_id');
}
