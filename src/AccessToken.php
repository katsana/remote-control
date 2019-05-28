<?php

namespace RemoteControl;

use Illuminate\Contracts\Auth\StatefulGuard;

class AccessToken implements Contracts\AccessToken
{
    /**
     * The secret passphrase.
     *
     * @var string
     */
    protected $secret;

    /**
     * The verification code.
     *
     * @var string
     */
    protected $verificationCode;

    /**
     * The record.
     *
     * @var array
     */
    protected $record;

    /**
     * Construct new access token.
     *
     * @param string $secret
     * @param string $verificationCode
     * @param array  $record
     */
    public function __construct(string $secret, string $verificationCode, $record)
    {
        $this->secret = $secret;
        $this->verificationCode = $verificationCode;
        $this->record = $record;
    }

    /**
     * Get secret passphrase.
     *
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }

    /**
     * Get verification code.
     *
     * @return string
     */
    public function getVerificationCode(): string
    {
        return $this->verificationCode;
    }

    /**
     * Get record id.
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->record['id'];
    }

    /**
     * Get user id.
     *
     * @return int|string|null
     */
    public function getUserId()
    {
        return $this->record['user_id'];
    }

    /**
     * Authenticate the user.
     *
     * @param \Illuminate\Contracts\Auth\StatefulGuard $guard
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|false
     */
    public function authenticate(StatefulGuard $guard)
    {
        return $guard->loginUsingId($this->getUserId(), false);
    }
}
