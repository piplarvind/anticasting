<?php
use App\Helpers\GlobalValues;
return [ 
    'client_id' => env('PAYPAL_CLIENT_ID',''),
    'secret' => env('PAYPAL_SECRET',''),
    //'client_id' => GlobalValues::get('paypal_client_id'),
    //'secret' => GlobalValues::get('paypal_client_secret'),
    'settings' => array(
        'mode' => env('PAYPAL_MODE','sandbox'),
        //'mode' => (GlobalValues::get('paypal_payment_mode') === '1')?'Live':'Sandbox',
        'http.ConnectionTimeOut' => 30,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        'log.LogLevel' => 'ERROR'
    ),
];