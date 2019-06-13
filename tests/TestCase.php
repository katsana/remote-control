<?php

namespace RemoteControl\Tests;

use Orchestra\Testbench\TestCase as Testing;

abstract class TestCase extends Testing
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/factories');
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $config = $app->make('config');

        $config->set([
            'auth.providers.users' => [
                'driver' => 'eloquent',
                'model' => \Illuminate\Foundation\Auth\User::class,
            ],
        ]);
    }

    /**
     * Get package aliases.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Remote' => 'RemoteControl\Remote',
        ];
    }

    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            'RemoteControl\RemoteServiceProvider',
        ];
    }
}
