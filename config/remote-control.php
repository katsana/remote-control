<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Hash Key
     |--------------------------------------------------------------------------
     |
     | Define the project hash key for remote control. It will fallback to
     | the application default key.
     |
     */

    'key' => env('REMOTE_CONTROL_KEY') ?? env('APP_KEY'),

    /*
     |--------------------------------------------------------------------------
     | Database configuration
     |--------------------------------------------------------------------------
     |
     | Define the project database configuration to manage remote control.
     |
     */

    'database' => [
        'table' => 'user_remote_controls',

        'connection' => null,
    ],
];
