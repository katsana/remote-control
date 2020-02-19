<?php

namespace RemoteControl\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use RemoteControl\Contracts\AccessToken;

class AccessTokenCreated
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
     * The message.
     *
     * @var string|null
     */
    public $message;

    /**
     * Requesting remote access event.
     */
    public function __construct(Authenticatable $user, AccessToken $accessToken, ?string $message)
    {
        $this->user = $user;
        $this->accessToken = $accessToken;
        $this->message = $message;
    }
}
