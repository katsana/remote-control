<?php

namespace RemoteControl\Contracts;

use Illuminate\Contracts\Auth\StatefulGuard;

interface AccessToken
{
    /**
     * Get secret passphrase.
     */
    public function getSecret(): string;

    /**
     * Get verification code.
     */
    public function getVerificationCode(): string;

    /**
     * Get record id.
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get user id.
     *
     * @return int|string|null
     */
    public function getUserId();

    /**
     * Get recipient e-mail address.
     */
    public function getEmail(): ?string;

    /**
     * Authenticate the user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|false
     */
    public function authenticate(StatefulGuard $guard);

    /**
     * Get URL.
     */
    public function getUrl(bool $absolute = true): string;

    /**
     * Get signed URL.
     *
     * @param \DateTimeInterface|\DateInterval|int $expiration
     */
    public function getSignedUrl($expiration = null, bool $absolute = true): string;
}
