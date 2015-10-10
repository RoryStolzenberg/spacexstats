<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAIL_DOMAIN'),
        'secret' => env('MAIL_SECRET'),
    ],

    'ses' => [
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => 'App\User',
        'secret' => '',
    ],

    'twilio' => [
        'sid' => env('TWILIO_SID'),
        'token' => env('TWILIO_TOKEN'),
        'fromNumber' => env('TWILIO_FROM_NUMBER')
    ],

    'twitter' => [
        'consumerKey' => env('TWITTER_CONSUMER_KEY'),
        'consumerSecret' => env('TWITTER_CONSUMER_SECRET'),
        'accessToken' => env('TWITTER_ACCESS_TOKEN'),
        'accessSecret' => env('TWITTER_ACCESS_SECRET')
    ],

    'reddit' => [
        'redditUsername' => env('REDDIT_USERNAME'),
        'redditPassword' => env('REDDIT_PASSWORD'),
        'redditId' => env('REDDIT_ID'),
        'redditSecret' => env('REDDIT_SECRET')
    ]
];
