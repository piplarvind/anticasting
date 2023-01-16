<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Visitor;

class GlobalValues {

    /**
     * this function is used to retrun all Global setting values.
     */
    public function getAll() {
        $glabal_values = DB::table('settings')
            ->get();
    }

    /**
     * return information of slug
     * @param $slug
     * @return string
     */
    public static function get($key) {

        $setting = DB::table('settings')
            ->where('key', '=', $key)
            ->get();
        if ($setting !== null && $setting != "[]") {
            $value = $setting->first()->value;
            return $value;
        } else {
            return "";
        }

        /*if (Cache::has($key)) {
            return Cache::get($key);
        } else {
            $expiresAt = Carbon::now()->addMinutes(10);
            $setting = DB::table('settings')
                ->where('key', '=', $key)
                ->get();
            if ($setting !== null && $setting != "[]") {
                $value = $setting->first()->value;
                Cache::put($key, $value, $expiresAt);
                return $value;
            } else {
                return "";
            }
        }*/

    }

    /**
     * return date format
     * @param $dtstr
     * @return false|string
     */
    public static function formatDate($dtstr) {
        if (Cache::has('date-format')) {
            $format = Cache::get('date-format');
        } else {
            $expiresAt = Carbon::now()->addMinutes(10);
            $format = GlobalValues::get('date-format');
            Cache::put('date-format', $format, $expiresAt);
        }
        return date($format, strtotime($dtstr));
    }

    public static function numberFormat($number) {
        return number_format((float)$number, 2,".",",");
    }

    public static function getVisitorCount(){
        return Visitor::sum('hits');
    }
}
