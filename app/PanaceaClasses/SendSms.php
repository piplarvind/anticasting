<?php

namespace App\PanaceaClasses;

use Twilio\Exceptions\TwilioException;

class SendSms {

    public function sendMessage($mobile_number_to_send, $message) {
        //'+919975159162'
//        Twilio::message($mobile_number_to_send, $message);
//         return "true";
//        try {
//            @Twilio::message($mobile_number_to_send, $message);
//            return "true";
//        } catch (\Services_Twilio_RestException $e) {
//            return "false";  
//        }

        $sid = ""; // Your Account SID from www.twilio.com/console
        $token = ""; // Your Auth Token from www.twilio.com/console
        try {
            $client = new \Twilio\Rest\Client($sid, $token);
            $message = $client->messages->create(
                    $mobile_number_to_send, // Text this number
                    array(
                'from' => '+18033730586', // From a valid Twilio number
                'body' => $message
                    )
            );
        } catch (TwilioException $exception) {
            return 'false';
        }
        return 'true';

        /* if($message->sid){
          return "true";
          }else{
          return "false";
          } */
    }

}
