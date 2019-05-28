<?php

namespace RemoteControl\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

interface TokenRepository
{
    /**
     * Create a new token.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param string                                     $email
     *
     * @return \RemoteControl\Contracts\AccessToken
     */
    public function create(Authenticatable $user, string $email): AccessToken;

    /**
     * Query existing record exists and yet to expired.
     *
     * @param string $email
     * @param string $secret
     * @param string $verificationCode
     *
     * @return \RemoteControl\Contracts\AccessToken|null
     */
    public function query(string $email, string $secret, string $verificationCode): ?AccessToken;

    /**
     * Determine if a token record exists and is valid.
     *
     * @param string $email
     * @param string $secret
     * @param string $verificationCode
     *
     * @return bool
     */
    public function exists(string $email, string $secret, string $verificationCode): bool;
}
