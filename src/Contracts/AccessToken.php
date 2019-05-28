<?php

namespace RemoteControl\Contracts;

use Illuminate\Contracts\Auth\StatefulGuard;

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
     *
     * @return string|null
     */
    public function getEmail(): ?string;

    /**
     * Authenticate the user.
     *
     * @param \Illuminate\Contracts\Auth\StatefulGuard $guard
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|false
     */
    public function authenticate(StatefulGuard $guard);


    /**
     * Get URL.
     *
     * @param bool $absolute
     *
     * @return string
     */
    public function getUrl(bool $absolute = true): string;

    /**
     * Get signed URL.
     *
     * @param \DateTimeInterface|\DateInterval|int $expiration
     * @param bool                                 $absolute
     *
     * @return string
     */
    public function getSignedUrl($expiration = null, bool $absolute = true): string;
}
