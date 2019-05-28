<?php

namespace RemoteControl\Contracts;

interface AccessToken
{
    /**
     * Get secret passphrase.
     *
     * @return string
     */
    public function getSecret(): string;

    /**
     * Get verification code.
     *
     * @return string
     */
    public function getVerificationCode(): string;

    /**
     * Get user id.
     *
     * @return int|string|null
     */
    public function getUserId();

    /**
     * Authenticate the user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|false
     */
    public function authenticateUser();
}
