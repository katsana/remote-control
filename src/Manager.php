<?php

namespace RemoteControl;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Str;

class Manager
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    public function __construct(Application $app, array $config)
    {
        $this->app = $app;
        $this->config = $config;
    }

    public function create(Authenticatable $user, string $email, string $message = ''): void
    {
        //
    }

    public function check(string $email, string $token, string $verificationCode)
    {
    }

    /**
     * Create a token repository instance based on the given configuration.
     *
     * @return \RemoteControl\Contracts\TokenRepositoryInterface
     */
    protected function createTokenRepository()
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
