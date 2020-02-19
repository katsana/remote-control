<?php

namespace RemoteControl;

use Illuminate\Contracts\Container\Container;
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
        $this->app->singleton('remote-control', static function (Container $app) {
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
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'remote-control');
        $this->mergeConfigFrom(__DIR__.'/../config/remote-control.php', 'remote-control');

        if ($this->app->runningInConsole()) {
            $this->registerMigrations();

            $this->publishes([
                __DIR__.'/../database/migrations' => \database_path('migrations'),
            ], 'remote-control:migrations');

            $this->publishes([
                __DIR__.'/../resources/views' => \resource_path('views/vendor/remote-control'),
            ], 'remote-control:views');

            $this->publishes([
                __DIR__.'/../config/remote-control.php' => \config_path('remote-control.php'),
            ], 'config');
        }
    }

    /**
     * Register Passport's migration files.
     */
    protected function registerMigrations(): void
    {
        if (Manager::$runsMigrations) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }
}
