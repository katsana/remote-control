<?php

namespace RemoteControl\Listeners;

use Illuminate\Support\Facades\Mail;
use RemoteControl\Events\AccessTokenCreated;
use RemoteControl\Mail\GrantRemoteAccess;

class SendInvitationEmail
{
    /**
     * Handle the event.
     *
     * @param \RemoteControl\Events\AccessTokenCreated $event
     *
     * @return void
     */
    public function handle(AccessTokenCreated $event)
    {
        Mail::send(
            new GrantRemoteAccess($event->user, $event->accessToken, $event->message)
        );
    }
}
