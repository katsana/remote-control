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
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param \RemoteControl\Contracts\AccessToken       $accessToken
     * @param string                                     $content
     */
    public function __construct(Authenticatable $user, AccessToken $accessToken, string $content = '')
    {
        $this->user = $user;
        $this->accessToken = $accessToken;
        $this->to[] = $accessToken->getEmail();
        $this->content = $content;
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
            'url' => $this->accessToken->getUrl(),
            'content' => $this->content,
        ]);
}
