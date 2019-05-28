<?php

namespace RemoteControl;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Support\Str;

class Manager implements Contracts\Factory
{
    /**
     * Indicates if remote control migrations will be run.
     *
     * @var bool
     */
    public static $runsMigrations = true;

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
     * Configure Passport to not register its migrations.
     *
     * @return void
     */
    public static function ignoreMigrations(): void
    {
        static::$runsMigrations = false;
    }

    /**
     * Create remote request.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param string                                     $email
     * @param string                                     $message
     *
     * @return \Illuminate\Contracts\Mail\Mailable
     */
    public function create(Authenticatable $user, string $email, string $message = ''): Mailable
    {
        $accessToken = $this->createTokenRepository()->create($user, $email);

        $mailable = $this->config['mailable'];

        return new $mailable($user, $email, $accessToken, $message);
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
        $repository = $this->createTokenRepository();

        $accessToken = $repository->query($email, $secret, $verificationCode);

        if (! $accessToken instanceof Contracts\AccessToken) {
            return false;
        }

        $accessToken->authenticate($this->app['auth']->guard());
        $repository->markAsUsed($accessToken->getId());

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
            $this->app['db']->connection($this->config['database']['connection'] ?? null),
            $this->app['hash'],
            $this->config['database']['table'] ?? 'user_remote_controls',
            $key
        );
    }
}
