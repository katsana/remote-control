<?php

namespace RemoteControl\Tests\Feature;

use Mockery as m;
use RemoteControl\Remote;
use RemoteControl\Tests\TestCase;
use Illuminate\Contracts\Auth\Authenticatable;

class CreateRemoteAccessTest extends TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate');
    }

    /** @test */
    public function it_can_create_remote_access()
    {
        $user = m::mock(Authenticatable::class);
        $user->shouldReceive('getKey')->andReturn(44);

        $accessToken = Remote::create($user, 'crynobone@katsana.com');

        $this->assertSame(44, $accessToken->getUserId());
        $this->assertSame('crynobone@katsana.com', $accessToken->getEmail());

        $this->assertDatabaseHas('user_remote_controls', [
            'user_id' => 44,
            'email' => 'crynobone@katsana.com',
            'verification_code' => $accessToken->getVerificationCode(),
        ]);
    }
}
