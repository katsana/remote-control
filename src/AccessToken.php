<?php

namespace RemoteControl;

use Illuminate\Contracts\Auth\StatefulGuard;

class AccessToken implements Contracts\Token
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
     * The user id.
     *
     * @var int|string|null
     */
    protected $userId;

    /**
     * Construct new access token.
     *
     * @param string          $secret
     * @param string          $verificationCode
     * @param int|string|null $userId
     */
    public function __construct(string $secret, string $verificationCode, $userId)
    {
        $this->secret = $secret;
        $this->verificationCode = $verificationCode;
        $this->userId = $userId;
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
     * Get user id.
     *
     * @return int|string|null
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Authenticate the user.
     *
     * @param \Illuminate\Contracts\Auth\StatefulGuard $guard
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|false
     */
    public function authenticateUser(StatefulGuard $guard)
    {
        return $guard->loginUsingId($this->userId, false);
    }
}
