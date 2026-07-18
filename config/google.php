<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Google API Application Name
    |--------------------------------------------------------------------------
    */
    'application_name' => env('GOOGLE_APPLICATION_NAME', ''),

    /*
    |--------------------------------------------------------------------------
    | Google OAuth Configuration
    |--------------------------------------------------------------------------
    */
    'client_id' => env('GOOGLE_CLIENT_ID', ''),
    'client_secret' => env('GOOGLE_CLIENT_SECRET', ''),
    'redirect_uri' => env('GOOGLE_REDIRECT', ''),
    'scopes' => ['https://www.googleapis.com/auth/drive', 'https://www.googleapis.com/auth/spreadsheets'],
    'access_type' => 'online',
    'approval_prompt' => 'auto',
    'prompt' => 'consent',

    /*
    |--------------------------------------------------------------------------
    | Google Developer Key
    |--------------------------------------------------------------------------
    */
    'developer_key' => env('GOOGLE_DEVELOPER_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Google Service Account
    |--------------------------------------------------------------------------
    */
    'service' => [
        /*
        | Enable service account auth or not.
        */
        'enable' => env('GOOGLE_SERVICE_ENABLED', true),

        /*
        | Path to service account json file.
        */
        'file' => env('GOOGLE_SERVICE_ACCOUNT_JSON_LOCATION', storage_path('app/google-credentials.json')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Additional config for the Google Client
    |--------------------------------------------------------------------------
    */
    'config' => [],

];
