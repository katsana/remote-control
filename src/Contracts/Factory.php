<?php

namespace RemoteControl\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Routing\Route;

interface Factory
{
    /**
     * Create remote request.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param string                                     $email
     * @param string|null                                $message
     *
     * @return \RemoteControl\Contracts\AccessToken
     */
    public function create(Authenticatable $user, string $email, ?string $message = null): AccessToken;

    /**
     * Authenticate remote request.
     *
     * @param string $email
     * @param string $secret
     * @param string $verificationCode
     *
     * @return bool
     */
    public function authenticate(string $email, string $secret, string $verificationCode): bool;

    /**
     * Register create routes for remote control.
     *
     * @param string      $prefix
     * @param string|null $controller
     *
     * @return \Illuminate\Routing\Route
     */
    public function createRoute(string $prefix, ?string $controller = null): Route;

    /**
     * Register verify routes for remote control.
     *
     * @param string      $prefix
     * @param string|null $controller
     *
     * @return \Illuminate\Routing\Route
     */
    public function verifyRoute(string $prefix, ?string $controller = null): Route;
}
