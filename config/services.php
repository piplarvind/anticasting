<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'facebook' => [
        'client_id' => '1654716034881925', //USE FROM FACEBOOK DEVELOPER ACCOUNT
        'client_secret' => 'c56c523e0bd2d9d05efb2e092f0a8c9b', //USE FROM FACEBOOK DEVELOPER ACCOUNT
        'redirect' => 'https://www.payzz.com/facebook/callback'
    ],

    'google' => [
        'client_id' => '377816538765-46djiqb6jnnutf16l7htsa4hpr29hnbt.apps.googleusercontent.com', //USE FROM FACEBOOK DEVELOPER ACCOUNT
        'client_secret' => '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', //USE FROM FACEBOOK DEVELOPER ACCOUNT
        'redirect' => 'https://www.payzz.com/google/callback'
    ],

];
