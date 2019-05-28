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
}
