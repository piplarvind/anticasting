<?php
namespace App\PiplModules\admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GlobalSetting
 * @package App\PiplModules\admin\Models
 */
class GlobalSetting extends Model 
{
	 protected $fillable = ['name','value','validate','lang_id'];
}