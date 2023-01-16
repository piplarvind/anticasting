<?php

namespace App\Helpers;


class GeneralHelper
{
    public static function greetingMsg()
    {
        //Here we define out main variables
        $welcome_string="Welcome!";
        $numeric_date = date("G");
        //Start conditionals based on military time
        if ($numeric_date >= 0 && $numeric_date <= 12) {
            $welcome_string = "Good Morning!";
        }
        else if ($numeric_date >= 12 && $numeric_date <= 17) {
            $welcome_string = "Good Afternoon!";
        }
        else if ($numeric_date >= 18 && $numeric_date <= 20) {
            $welcome_string = "Good Evening!";
        }
        else {
            $welcome_string = "Good Night!";
        }
        //Display our greeting
        return "$welcome_string";

    }

    // Get SEO URL function here
    public static function seoUrl($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // trim
        $text = trim($text, '-');
        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        // lowercase
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

    // Function to generate OTP
    public static function generateNumericOTP($n) {
        
        // Take a generator string which consist of
        // all numeric digits
        $generator = "1357902468";
    
        // Iterate for n-times and pick a single character
        // from generator and append it to $result
        
        // Login for generating a random character from generator
        //     ---generate a random number
        //     ---take modulus of same with length of generator (say i)
        //     ---append the character at place (i) from generator to result
    
        $result = "";
    
        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand()%(strlen($generator))), 1);
        }
    
        // Return result
        return $result;
    }

    /*
    * Generate random string
    */
    public static function generateReferenceNumber()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
    }

    /*
    * To check the unique key
    */
    public static function uniqueKey($array, $keyname)
    {
        $new_array = array();
        foreach ($array as $key=>$value) {
            if (!isset($new_array[$value[$keyname]])) {
                $new_array[$value[$keyname]] = $value;
            }
        }
        $new_array = array_values($new_array);
        return $new_array;
    }

    /*
    * Thuns API call
    */
    public static function thunesAPI($url, $request_type, $post_data=[])
    {
        try{
            $full_url = config('app.thunes_base_url').config('app.thunes_version_url').$url;
            $headers = array(
                'Content-Type:application/json',
                'Authorization: Basic ' . base64_encode(config('app.thunes_api_key') . ":" . config('app.thunes_api_secret'))
            );
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $full_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_POSTFIELDS => json_encode($post_data),
                CURLOPT_CUSTOMREQUEST => $request_type,
                CURLOPT_HTTPHEADER => $headers
            ));
            $return = curl_exec($curl);
            //dd($return);
            curl_close($curl);
            return json_decode($return);
        }
        catch (Exception $e) {
            $return = ['error'=>1, 'message'=>$e->getMessage()];
            return json_decode($return);
        }
    }
}