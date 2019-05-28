<?php

namespace RemoteControl;

use Illuminate\Support\ServiceProvider;

class RemoteServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('remote-control', function (Application $app) {
            return new Manager($app, \config('remote-control'));
        });
    }
}
