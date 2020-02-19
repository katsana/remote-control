<?php

namespace RemoteControl\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

interface TokenRepository
{
    /**
     * Create a new token.
     *
     * @return \RemoteControl\Contracts\AccessToken
     */
    public function create(Authenticatable $user, string $email): AccessToken;

    /**
     * Query existing record exists and yet to expired.
     *
     * @return \RemoteControl\Contracts\AccessToken|null
     */
    public function query(string $email, string $secret, string $verificationCode): ?AccessToken;

    /**
     * Mark token as used.
     *
     * @param int $recordId
     */
    public function markAsUsed($recordId): void;
}
