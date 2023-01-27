<?php
namespace App\Helpers;

use App\Modules\Settings\Models\Setting;

class GlobalVariable
{
   
    public static function get($key){

        $setting = Setting::where('key', '=', $key)
            ->get();
     //   dd($setting);   
            if($setting != null && $setting != '[]')
            {
               $value = $setting->first()->value;
      
               return $value;
            }
            else{
            return " ";
            }

      
    }
}
