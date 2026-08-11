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
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],

    'firebase' => [
        'api_key' => env('FIREBASE_API_KEY', 'AIzaSyDhgFP1uFALZmu0R3tZSyT7AjH831sGkxM'),
        'auth_domain' => env('FIREBASE_AUTH_DOMAIN', 'tribecanet.firebaseapp.com'),
        'project_id' => env('FIREBASE_PROJECT_ID', 'tribecanet'),
        'storage_bucket' => env('FIREBASE_STORAGE_BUCKET', 'tribecanet.firebasestorage.app'),
        'messaging_sender_id' => env('FIREBASE_MESSAGING_SENDER_ID', '394345136176'),
        'app_id' => env('FIREBASE_APP_ID', '1:394345136176:web:5398d7020b1cf644e86df5'),
        'measurement_id' => env('FIREBASE_MEASUREMENT_ID', 'G-NJGWGJ1JRZ'),
    ],

];
