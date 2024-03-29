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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id' => '335516445980-mjidvqrvtd152k6nioc9pohr2ttrj2mk.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://127.0.0.1:8000/login/google/callback',
    ],

    'github' => [
        'client_id' => 'dcf9394d9179cd25c3bf',
        'client_secret' => 'c4ee752ebd3133eb8ac87f0f2dabfe942ee33a75',
        'redirect' => 'http://127.0.0.1:8000/login/github/callback',
    ],
];
