<?php

namespace RemoteControl\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Routing\Route;

interface Factory
{
    /**
     * Create remote request.
     *
     * @return \RemoteControl\Contracts\AccessToken
     */
    public function create(Authenticatable $user, string $email, ?string $message = null): AccessToken;

    /**
     * Authenticate remote request.
     */
    public function authenticate(string $email, string $secret, string $verificationCode): bool;

    /**
     * Register create routes for remote control.
     */
    public function createRoute(string $prefix, ?string $controller = null): Route;

    /**
     * Register verify routes for remote control.
     */
    public function verifyRoute(string $prefix, ?string $controller = null): Route;
}
