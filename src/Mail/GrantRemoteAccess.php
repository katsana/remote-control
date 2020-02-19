<?php

namespace RemoteControl\Mail;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Mail\Mailable;
use RemoteControl\Contracts\AccessToken;

class GrantRemoteAccess extends Mailable
{
    /**
     * The user.
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    public $user;

    /**
     * Access token.
     *
     * @var \RemoteControl\Contracts\AccessToken
     */
    public $accessToken;

    /**
     * Message content.
     *
     * @var string
     */
    public $content;

    /**
     * Construct a new mailable to grant remote access.
     */
    public function __construct(Authenticatable $user, AccessToken $accessToken, string $content = '')
    {
        $this->user = $user;
        $this->accessToken = $accessToken;
        $this->content = $content;

        $this->to($accessToken->getEmail());
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('remote-control::grant-remote-access', [
            'user' => $this->user,
            'url' => $this->accessToken->getSignedUrl(),
            'content' => $this->content,
        ]);
    }
}
