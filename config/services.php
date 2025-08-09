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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'firebase' => [
        'api_key'                => 'AIzaSyAJhkCyNT0be2x6FSzyUz0Ye9xX-QihIBo',
        'auth_domain'            => 'bijaksampah-aeb82.firebaseapp.com',
        'database_url'           => 'https://bijaksampah-aeb82-default-rtdb.asia-southeast1.firebasedatabase.app',
        'project_id'             => 'bijaksampah-aeb82',
        'storage_bucket'         => 'bijaksampah-aeb82.firebasestorage.app',
        'messaging_sender_id'    => '140467230562',
        'app_id'                 => '1:140467230562:web:19a34dfefcb6f65bd7fe3b',
        'credentials_file'       => storage_path('app/firebase/firebase_credentials.json'),
    ],

];
