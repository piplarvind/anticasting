<?php

namespace App\PiplModules\admin\Helpers;

use App\PiplModules\admin\Models\GlobalSetting;
use App\PiplModules\service\Models\Service;
use Cache;
use DB;
use Carbon\Carbon;

class GlobalValues {

    /**
     * this function is used to retrun all Global setting values.
     */
    public function getAll() {
        $glabal_values = GlobalSetting::all();
    }

    /**
     * return information of slug
     * @param $slug
     * @return string
     */
    public static function get($slug) {
        if (Cache::has($slug)) {
            return Cache::get($slug);
        } else {
            $expiresAt = Carbon::now()->addMinutes(10);
            $setting = GlobalSetting::where('slug', $slug)->get();
            if ($setting !== null && $setting != "[]") {
                $value = $setting->first()->value;
                Cache::put($slug, $value, $expiresAt);
                return $value;
            } else {
                return "";
            }
        }
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

    /**
     * return user wallet balance using user_id
     * @param $user_id
     * @return float|mixed
     */
    public static function userBalance($user_id) {
        $all_wallet_data = array();
        $sql = "SELECT user_id , SUM(COALESCE(CASE WHEN transaction_type = '1' THEN final_amout END,0)) total_debits , SUM(COALESCE(CASE WHEN transaction_type = '0' THEN final_amout END,0)) total_credits , (SUM(COALESCE(CASE WHEN transaction_type = '0' THEN final_amout END,0)) - SUM(COALESCE(CASE WHEN transaction_type = '1' THEN final_amout END,0))) balance FROM " . DB::getTablePrefix() . "user_wallet_details WHERE user_id=" . $user_id . " AND payment_receipt_flag='0' GROUP BY user_id HAVING balance <> 0";
        $user_wallet_data = DB::select(DB::raw($sql));
        if (isset($user_wallet_data) && count($user_wallet_data)) {
            $all_wallet_data = (array) $user_wallet_data[0];
        }
        if (isset($all_wallet_data) & count($all_wallet_data) > 0) {
            return ($all_wallet_data['balance']) ? self::priceConversion($all_wallet_data['balance']) : self::priceConversion(0.00);
        } else {
            return self::priceConversion(0.00);
        }
    }

    /**
     * return service type name using id
     * @param $service_id
     * @return string
     */
    public static function getServiceName($service_id) {
        $all_services = Service::translatedIn(\App::getLocale())->where('id', $service_id)->first();
        if (isset($all_services) && $all_services->count() > 0) {
            return $all_services->name;
        }else{
           return '-'; 
        }
    }

    /**
     * This function is used for price conversion
     * @param string $price
     * @return float|string
     */
    public static function priceConversion($price = '') {
        $pri = '0.000';
        $tmp_val = explode('.', $price);
        $temp = 0;
        if (count($tmp_val) > 1) {
            $val = str_split($tmp_val[1]);
            if (isset($val[1]) && (($val[1] == '5') || ($val[1] == '4') || ($val[1] == '3') || ($val[1] == '2') || ($val[1] == '1'))) {
                $pri = $tmp_val[0] . '.' . $val[0] . '5';
            } elseif (isset($val[1]) && (($val[1] == '9') || ($val[1] == '8') || ($val[1] == '7') || ($val[1] == '6'))) {
                if ($val[0] == '9') {
                    $pri = round($price);
                } else {
                    $temp = 10 - $val[1];
                    $temp = substr($tmp_val[1], '0', '2') + $temp;
                    $pri = $tmp_val[0] . '.' . $temp;
                }
            } else {
                $pri = $tmp_val[0] . '.' . $val[0] . '0';
            }
        } else {
            $pri = $price;
        }
        return $pri;
    }
}
