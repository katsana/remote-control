<?php

namespace RemoteControl;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Manager
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    protected $config;

    public function __construct(Application $app, array $config)
    {
        $this->app = $app;
        $this->config = $config;
    }

    public function create(Authenticatable $user, string $email, string $message = ''): void
    {
        $accessToken = $this->createTokenRepository()->create(
            $user, $email, $message
        );

        $mailable = $this->config['mailable'];

        Mail::to($email)->send(new $mailable($user, $accessToken));
    }

    /**
     * Authenticate request.
     *
     * @param string $email
     * @param string $secret
     * @param string $verificationCode
     *
     * @return bool
     */
    public function authenticate(string $email, string $secret, string $verificationCode): bool
    {
        $accessToken = $this->createTokenRepository()->query(
            $email, $secret, $verificationCode
        );

        if (! $accessToken instanceof Contracts\AccessToken) {
            return false;
        }

        $accessToken->authenticateUser();

        return true;
    }

    /**
     * Create a token repository instance based on the given configuration.
     *
     * @return \RemoteControl\Contracts\TokenRepository
     */
    protected function createTokenRepository(): Contracts\TokenRepository
    {
        $key = $this->config['key'];

        if (Str::startsWith($key, 'base64:')) {
            $key = \base64_decode(\substr($key, 7));
        }

        return new DatabaseTokenRepository(
            $this->app['db']->connection($this->config['connection'] ?? null),
            $this->app['hash'],
            $this->config['table'],
            $key,
            $this->config['expire']
        );
    }
}
