<?php

namespace RemoteControl\Mail;

use Illuminate\Mail\Mailable;
use RemoteControl\Contracts\AccessToken;
use Illuminate\Contracts\Auth\Authenticatable;

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
