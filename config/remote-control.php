<?php

return [
    'key' => env('REMOTE_CONTROL_KEY') ?? env('APP_KEY'),

    'table' => 'user_remote_controls',

    'mailable' => RemoteControl\Mail\GrantRemoteAccess::class,

    'expire' => 120,
];
