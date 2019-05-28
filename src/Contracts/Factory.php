<?php

namespace RemoteControl\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Mail\Mailable;

interface Factory
{
    /**
     * Create remote request.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param string                                     $email
     * @param string                                     $message
     *
     * @return \Illuminate\Contracts\Mail\Mailable
     */
    public function create(Authenticatable $user, string $email, string $message = ''): Mailable;

    /**
     * Authenticate remote request.
     *
     * @param string $email
     * @param string $secret
     * @param string $verificationCode
     *
     * @return bool
     */
    public function authenticate(string $email, string $secret, string $verificationCode): bool;
}
