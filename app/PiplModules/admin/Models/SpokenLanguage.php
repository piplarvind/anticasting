<?php
namespace App\PiplModules\admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SpokenLanguage
 * @package App\PiplModules\admin\Models
 */
class SpokenLanguage extends Model
{
    use \Dimsav\Translatable\Translatable;
    public $translatedAttributes = ['name'];
    protected $fillable = ['name','lang_icon'];
}
