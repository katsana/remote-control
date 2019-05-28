<?php

namespace RemoteControl\Tests\Unit\Concerns;

use PHPUnit\Framework\TestCase;
use RemoteControl\Concerns\GeneratesAccessTokens;

class GeneratesAccessTokensTest extends TestCase
{
    use GeneratesAccessTokens;

    protected function setUp(): void
    {
        $this->hashKey = 'secret';
    }

    /** @test */
    public function it_can_generate_secret()
    {
        $secret = $this->generateSecret();

        $this->assertTrue(is_string($secret));
        $this->assertTrue(strlen($secret) === 64);
    }
}
