<?php

namespace RemoteControl\Tests\Feature;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\Concerns\WithLaravelMigrations;
use RemoteControl\Events\RemoteAccessCreated;
use RemoteControl\Events\RemoteAccessUsed;
use RemoteControl\Remote;
use RemoteControl\Tests\TestCase;

class RemoteAccessTest extends TestCase
{
    use WithLaravelMigrations;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations('testing');
        $this->artisan('migrate');
    }

    /** @test */
    public function it_can_create_remote_access()
    {
        Event::fake();

        $user = factory(User::class)->create();

        $accessToken = Remote::create($user, 'crynobone@katsana.com');

        $this->assertSame($user->getKey(), $accessToken->getUserId());
        $this->assertSame('crynobone@katsana.com', $accessToken->getEmail());

        $this->assertDatabaseHas('user_remote_controls', [
            'user_id' => $user->getKey(),
            'email' => 'crynobone@katsana.com',
            'verification_code' => $accessToken->getVerificationCode(),
        ]);

        Event::assertDispatched(RemoteAccessCreated::class, function ($event) use ($accessToken) {
            return $event->accessToken === $accessToken;
        });
    }

    /** @test */
    public function it_can_create_remote_access_via_http()
    {
        Event::fake();

        Remote::createRoute('test')->middleware(['web']);

        $user = factory(User::class)->create();

        $this->be($user);

        $this->call('POST', 'test/create', [
            'email' => 'crynobone@katsana.com',
        ])->assertRedirect('/');

        $this->assertDatabaseHas('user_remote_controls', [
            'user_id' => $user->getKey(),
            'email' => 'crynobone@katsana.com',
        ]);

        Event::assertDispatched(RemoteAccessCreated::class, function ($event) {
            return $event->accessToken->getEmail() === 'crynobone@katsana.com';
        });
    }

    /** @test */
    public function it_can_authenticate_remote_access()
    {
        Event::fake();

        $user = factory(User::class)->create();

        $accessToken = Remote::create($user, 'crynobone@katsana.com');

        $this->assertGuest();

        Remote::authenticate('crynobone@katsana.com', $accessToken->getSecret(), $accessToken->getVerificationCode());

        $this->assertAuthenticatedAs($user);

        Event::assertDispatched(RemoteAccessUsed::class, function ($event) use ($accessToken) {
            return $event->accessToken->getEmail() === $accessToken->getEmail();
        });
    }

    /** @test */
    public function it_can_authenticate_remote_access_via_http_request()
    {
        Event::fake();

        Remote::verifyRoute('test')->middleware(['web']);

        $user = factory(User::class)->create();

        $accessToken = Remote::create($user, 'crynobone@katsana.com');

        $this->assertGuest();

        $this->call('GET', $accessToken->getUrl(false))->assertRedirect('/');

        $this->assertAuthenticatedAs($user);

        Event::assertDispatched(RemoteAccessUsed::class, function ($event) use ($accessToken) {
            return $event->accessToken->getEmail() === $accessToken->getEmail();
        });
    }

    /** @test */
    public function it_can_authenticate_remote_access_via_signed_http_request()
    {
        Event::fake();

        Remote::verifyRoute('test')->middleware(['signed', 'web']);

        $user = factory(User::class)->create();

        $accessToken = Remote::create($user, 'crynobone@katsana.com');

        $this->assertGuest();

        $this->call('GET', $accessToken->getSignedUrl(false))->assertRedirect('/');

        $this->assertAuthenticatedAs($user);

        Event::assertDispatched(RemoteAccessUsed::class, function ($event) use ($accessToken) {
            return $event->accessToken->getEmail() === $accessToken->getEmail();
        });
    }
}
