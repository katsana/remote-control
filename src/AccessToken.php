<?php

namespace RemoteControl;

use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Contracts\Auth\Authenticatable|false
     */
    public function authenticateUser()
    {
        return Auth::loginUsingId($this->userId, false);
    }
}
