<?php

namespace RemoteControl\Mail;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Mail\Mailable;
use RemoteControl\Contracts\AccessToken;

class GrantRemoteAccess extends Mailable
{
    public $user;
    public $accessToken;

    public function __construct(Authenticatable $user, AccessToken $accessToken)
    {
        $this->user = $user;
        $this->accessToken = $accessToken;
    }
}
