<?php

namespace RemoteControl\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use RemoteControl\Contracts\AccessToken;

class RemoteAccessCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

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
