<?php

namespace RemoteControl;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Support\Str;

class Manager implements Contracts\Factory
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Remote control configuration.
     *
     * @var array
     */
    protected $config;

    /**
     * Construct a new remote control manager.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param array                                        $config
     */
    public function __construct(Application $app, array $config)
    {
        $this->app = $app;
        $this->config = $config;
    }

    /**
     * Create remote request.
     *
     * @param string $email
     * @param string $secret
     * @param string $verificationCode
     *
     * @return \Illuminate\Contracts\Mail\Mailable
     */
    public function create(Authenticatable $user, string $email, string $message = ''): Mailable
    {
        $accessToken = $this->createTokenRepository()->create(
            $user, $email, $message
        );

        $mailable = $this->config['mailable'];

        return new $mailable($user, $accessToken);
    }

    /**
     * Authenticate remote request.
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

        $accessToken->authenticateUser($this->app['auth']->guard());

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
