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
     * @param string                                     $message
     *
     * @return string
     */
    public function create(Authenticatable $user, string $email, string $message = ''): string;

    /**
     * Determine if a token record exists and is valid.
     *
     * @param string $email
     * @param string $token
     * @param string $verificationCode
     *
     * @return bool
     */
    public function exists(string $email, string $token, string $verificationCode): bool;

    /**
     * Delete a token record.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     *
     * @return void
     */
    public function delete(Authenticatable $user): void;

    /**
     * Delete expired tokens.
     *
     * @return void
     */
    public function deleteExpired(): void;
}
