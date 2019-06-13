<?php

namespace RemoteControl\Events;

use Illuminate\Contracts\Auth\Authenticatable;

class RemoteAccessCreated
{
    /**
     * The user.
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    public $user;

    /**
     * The recipient e-mail adddress.
     *
     * @var string
     */
    public $email;

    /**
     * Requesting remote access event.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param string                                     $email
     */
    public function __construct(Authenticatable $user, string $email)
    {
        $this->user = $user;
        $this->email = $email;
    }
}
