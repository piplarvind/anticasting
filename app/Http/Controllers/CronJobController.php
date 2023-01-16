<?php

namespace App\Http\Controllers;
use Piplmodules\Settings\Models\Setting;


class CronJobController
{

    public function currencyConverter(){
        // Fetching JSON
        $req_url = 'https://api.exchangerate-api.com/v4/latest/INR';
        $response_json = file_get_contents($req_url);

// Continuing if we got a result
        if(false !== $response_json) {

            // Try/catch for json_decode operation
            try {
                // Decoding
                $response_object = json_decode($response_json);

                $inr_to_usdSetting = Setting::find(12);

                $inr_to_usdSetting->value = $response_object->rates->USD;
                $inr_to_usdSetting->save();

                // YOUR APPLICATION CODE HERE, e.g.
                $base_price = 249; // Your price in INR
                $USD_price = round(($base_price * $response_object->rates->USD), 2);
            }
            catch(Exception $e) {
                // Handle JSON parse error...
            }
        }
    }
}