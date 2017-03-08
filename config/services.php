<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'facebook' => [
        'client_id'     => '1867537673522826',
        'client_secret' => 'bb698555ccce032a07ec4977aefafe1c',
        'redirect'      => 'http://pimboo.local/login/callback/facebook',
    ],
    'google' => [
        'client_id' => '529934983719-udk3irn0msc0klajqoj6288gaesabric.apps.googleusercontent.com',
        'client_secret' => '7qthOvZ4cFLkuQCfjw39j8xx',
        'redirect' => 'http://pimboobeta.com/login/callback/google',
    ],
];
