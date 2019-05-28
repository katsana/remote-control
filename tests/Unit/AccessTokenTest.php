<?php

namespace RemoteControl\Tests\Unit;

use Mockery as m;
use RemoteControl\AccessToken;
use PHPUnit\Framework\TestCase;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Auth\Authenticatable;

class AccessTokenTest extends TestCase
{
    /**
     * Teardown the test environment.
     */
    protected function tearDown(): void
    {
        m::close();
    }

    /** @test */
    public function it_can_be_initiated()
    {
        $accessToken = new AccessToken('foo', 'bar', [
            'id' => 2,
            'email' => 'crynobone@katsana.com',
            'user_id' => 5,
        ]);

        $this->assertSame('foo', $accessToken->getSecret());
        $this->assertSame('bar', $accessToken->getVerificationCode());
        $this->assertSame(2, $accessToken->getId());
        $this->assertSame(5, $accessToken->getUserId());
        $this->assertSame('crynobone@katsana.com', $accessToken->getEmail());
        $this->assertInstanceOf('RemoteControl\Contracts\AccessToken', $accessToken);
    }

    /** @test */
    public function it_can_authenticate_user()
    {
        $accessToken = new AccessToken('foo', 'bar', [
            'id' => 2,
            'user_id' => 5,
        ]);

        $user = m::mock(Authenticatable::class);
        $guard = m::mock(StatefulGuard::class);

        $guard->shouldReceive('loginUsingId')->once()->with(5, false)->andReturn($user);

        $this->assertSame($user, $accessToken->authenticate($guard));
    }
}
