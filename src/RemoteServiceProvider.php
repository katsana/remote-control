<?php

namespace RemoteControl;

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
        $this->publishes([
            __DIR__.'/../config/remote-control.php' => \config_path('remote-control.php'),
        ], 'config');
    }
}
