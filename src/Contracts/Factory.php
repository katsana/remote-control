<?php

namespace RemoteControl\Contracts;

use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Contracts\Auth\Authenticatable;

interface Factory
{
    /**
     * Create remote request.
     *
     * @param string $email
     * @param string $secret
     * @param string $verificationCode
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
