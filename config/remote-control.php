<?php

return [
    'key' => env('REMOTE_CONTROL_KEY') ?? env('APP_KEY'),

    'database' => [
        'table' => 'user_remote_controls',

        'connection' => null,
    ],

    'mailable' => RemoteControl\Mail\GrantRemoteAccess::class,
];
