<?php

namespace RemoteControl\Tests\Unit;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\StatefulGuard;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use RemoteControl\AccessToken;

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

    /** @test */
    public function it_can_be_serialized()
    {
        $accessToken = new AccessToken('foo', 'bar', [
            'id' => 2,
            'email' => 'crynobone@katsana.com',
            'user_id' => 5,
        ]);

        $serialized = serialize($accessToken);

        $this->assertSame(
            'C:25:"RemoteControl\AccessToken":155:{a:3:{s:6:"secret";s:3:"foo";s:17:"verification_code";s:3:"bar";s:6:"record";a:3:{s:2:"id";i:2;s:5:"email";s:21:"crynobone@katsana.com";s:7:"user_id";i:5;}}}',
            $serialized
        );
    }

    /** @test */
    public function it_can_be_unserialized()
    {
        $serialized = 'C:25:"RemoteControl\AccessToken":155:{a:3:{s:6:"secret";s:3:"foo";s:17:"verification_code";s:3:"bar";s:6:"record";a:3:{s:2:"id";i:2;s:5:"email";s:21:"crynobone@katsana.com";s:7:"user_id";i:5;}}}';

        $accessToken = new AccessToken('foo', 'bar', [
            'id' => 2,
            'email' => 'crynobone@katsana.com',
            'user_id' => 5,
        ]);

        $accessToken = unserialize($serialized);

        $this->assertSame('foo', $accessToken->getSecret());
        $this->assertSame('bar', $accessToken->getVerificationCode());
        $this->assertSame(2, $accessToken->getId());
        $this->assertSame(5, $accessToken->getUserId());
        $this->assertSame('crynobone@katsana.com', $accessToken->getEmail());
        $this->assertInstanceOf('RemoteControl\Contracts\AccessToken', $accessToken);
    }
}
