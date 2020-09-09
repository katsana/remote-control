<?php

namespace RemoteControl\Tests\Feature;

use Illuminate\Support\Facades\Mail;
use Orchestra\Testbench\Concerns\WithLaravelMigrations;
use Orchestra\Testbench\Factories\UserFactory;
use RemoteControl\Mail\GrantRemoteAccess;
use RemoteControl\Remote;
use RemoteControl\Tests\TestCase;

class SendNotificationTest extends TestCase
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
    public function it_can_send_email_notification()
    {
        Mail::fake();

        $user = UserFactory::new()->create();

        $accessToken = Remote::create($user, 'crynobone@katsana.com');

        Mail::send(new GrantRemoteAccess($user, $accessToken, 'Hello'));

        Mail::assertSent(GrantRemoteAccess::class, function ($mail) use ($user, $accessToken) {
            return $mail->hasTo('crynobone@katsana.com') && $mail->accessToken == $accessToken;
        });
    }
}
