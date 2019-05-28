<?php

namespace RemoteControl\Concerns;

use Illuminate\Support\Str;

trait GeneratesAccessTokens
{
    /**
     * The hashing key.
     *
     * @var string
     */
    protected $hashKey;

    /**
     * Create a new secret for the user.
     *
     * @return string
     */
    public function generateSecret(): string
    {
        return \hash_hmac('sha256', Str::random(40), $this->hashKey);
    }

    /**
     * Create a new token for the user.
     *
     * @param string $characters
     * @param int    $length
     *
     * @return string
     */
    public function generateVerificationCode(
        string $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        int $length = 5
    ): string {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $limit = \strlen($characters) - 1;
        $code = [];

        while ($length--) {
            $code[] = $characters[\rand(0, $limit)];
        }

        return \implode('', $code);
    }
}
