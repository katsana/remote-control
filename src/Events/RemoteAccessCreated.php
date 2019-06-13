<?php

namespace RemoteControl\Events;

use Illuminate\Contracts\Auth\Authenticatable;
use RemoteControl\Contracts\AccessToken;

class RemoteAccessCreated
{
    /**
     * The user.
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    public $user;

    /**
     * The access token.
     *
     * @var \RemoteControl\Contracts\AccessToken
     */
    public $accessToken;

    /**
     * Requesting remote access event.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param \RemoteControl\Contracts\AccessToken       $accessToken
     */
    public function __construct(Authenticatable $user, AccessToken $accessToken)
    {
        $this->user = $user;
        $this->accessToken = $accessToken;
    }
}
