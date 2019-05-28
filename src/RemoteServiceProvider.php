<?php

namespace RemoteControl;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class RemoteServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('remote-control', function (Application $app) {
            return new Manager($app, \config('remote-control'));
        });
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerMigrations();

            $this->publishes([
                __DIR__.'/../database/migrations' => \database_path('migrations'),
            ], 'remote-migrations');

            $this->publishes([
                __DIR__.'/../config/remote-control.php' => \config_path('remote-control.php'),
            ], 'config');
        }
    }

    /**
     * Register Passport's migration files.
     *
     * @return void
     */
    protected function registerMigrations(): void
    {
        if (Manager::$runsMigrations) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }
}
