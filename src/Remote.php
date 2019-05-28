<?php

namespace RemoteControl;

use Illuminate\Support\Facades\Facade;

class Remote extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'remote-control';
    }
}
