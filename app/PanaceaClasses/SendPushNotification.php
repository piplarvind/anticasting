<?php

namespace App\PanaceaClasses;

use Davibennun\LaravelPushNotification\Facades\PushNotification;

class SendPushNotification
{
    /**
     * This function is used for send push notification to ios passenger
     * @param $arrayToSend
     * @return string
     */
    public function iOSPushNotificaton($arrayToSend)
    {
        $fcmApiKey = 'AIzaSyBh4EnZwIJKQOJgmcCLp73FGVQIZK39SZU'; //App API Key(This is google cloud messaging api key not web api key)
        $url = 'https://fcm.googleapis.com/fcm/send'; //Google URL
        //Fcm Device ids array

        $headers = array(
            'Authorization: key=' . $fcmApiKey,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arrayToSend);
        // Execute post
        $result = curl_exec($ch);

        // Close connection
        curl_close($ch);
        return "1";
    }

    /**
     * This function is used for send push notification to android passenger
     *
     * @param $arrayToSend
     * @return string
     */
    public function androidPushNotificaton($arrayToSend)
    {
        $arrayToSendTo = json_decode($arrayToSend);

        $device_id = isset($arrayToSendTo->to) ? $arrayToSendTo->to : '';

        if ($device_id != '') {
            $response = PushNotification::app('appNameAndroidCustomer')
                ->to($device_id)
                ->send(($arrayToSend));
        }
    }

    /**
     * This function is used for send push notification to ios driver
     *
     * @param $arrayToSend
     * @param string $user_type
     * @return string
     */
    public function iOSPushNotificatonDriver($arrayToSend, $user_type = '')
    {
        if ($user_type == '5') {
            $fcmApiKey = 'AIzaSyBh4EnZwIJKQOJgmcCLp73FGVQIZK39SZU'; //App API Key(This is google cloud messaging api key not web api key)
        } elseif ($user_type == '4') {
            $fcmApiKey = 'AIzaSyDtJHe0x2Iul-ANl2-1NV8WOVs05iMEt-g'; //App API Key(This is google cloud messaging api key not web api key)
        }

        $url = 'https://fcm.googleapis.com/fcm/send'; //Google URL
        //Fcm Device ids array

        $headers = array(
            'Authorization: key=' . $fcmApiKey,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CAINFO, app_path() . "/cacert.pem");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arrayToSend);
        // Execute post
        $result = curl_exec($ch);
        curl_close($ch);
        return "1";
    }

    /**
     *This function is used for send push notification to android driver
     *
     * @param $arrayToSend
     * @param string $to
     * @param string $user_type
     * @return mixed
     */
    public function androidPushNotification($arrayToSend, $to = "", $user_type = '')
    {
        if ($user_type == '5') {
            $fcmApiKey = 'AIzaSyBFaUnGmHGtBwHXxA3xQe2snSMBdxm_yUo'; // Passanger App API Key(This is google cloud messaging api key not web api key)
        } elseif ($user_type == '4') {
            $fcmApiKey = 'AIzaSyDxUMIul_n_27IaobfdeoPZfyxrE-zxsM8'; // Driver App API Key(This is google cloud messaging api key not web api key)
        }
        $url = 'https://fcm.googleapis.com/fcm/send'; //Google URL
        //Fcm Device ids array

        $headers = [
            'Authorization: key=' . $fcmApiKey,
            'Content-Type: application/json'
        ];

        $fields = [
            'to' => $to,
            'collapse_key' => "type_a",
            /*'notification' => $arrayToSend['notification'],*/
            'data' => $arrayToSend['data'],
        ];
        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        // Execute post
        $result = json_decode(curl_exec($ch));
        // Close connection
        curl_close($ch);
        return $result;
    }

}
