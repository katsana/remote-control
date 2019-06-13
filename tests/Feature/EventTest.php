<?php

namespace RemoteControl\Tests\Feature;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Orchestra\Testbench\Concerns\WithLaravelMigrations;
use RemoteControl\Events\AccessTokenCreated;
use RemoteControl\Listeners\SendInvitationEmail;
use RemoteControl\Mail\GrantRemoteAccess;
use RemoteControl\Remote;
use RemoteControl\Tests\TestCase;

class EventTest extends TestCase
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
        Mail::fake();
        Event::listen(AccessTokenCreated::class, SendInvitationEmail::class);

        $user = factory(User::class)->create();

        $accessToken = Remote::create($user, 'crynobone@katsana.com');

        $this->assertDatabaseHas('user_remote_controls', [
            'user_id' => $user->getKey(),
            'email' => 'crynobone@katsana.com',
            'verification_code' => $accessToken->getVerificationCode(),
        ]);

        Mail::assertSent(GrantRemoteAccess::class, function ($mail) use ($accessToken) {
            return $mail->hasTo($accessToken->getEmail());
        });
    }
}
