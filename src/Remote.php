<?php

namespace RemoteControl;

use Illuminate\Support\Facades\Facade;

/**
 * @method \Illuminate\Contracts\Mail\Mailable create(\Illuminate\Contracts\Auth\Authenticatable $user, string $email, string $message = '')
 * @method bool authenticate(string $email, string $secret, string $verificationCode)
 *
 * @see \RemoteControl\Manager
 */
class Remote extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'remote-control';
    }
}
