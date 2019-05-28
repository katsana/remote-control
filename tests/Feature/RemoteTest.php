<?php

namespace RemoteControl\Tests\Feature;

use RemoteControl\Remote;
use RemoteControl\Tests\TestCase;

class RemoteTest extends TestCase
{
    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        config([
            'remote-control' => [],
        ]);
    }

    /** @test */
    public function it_can_resolve_the_facade()
    {
        $remote = Remote::getFacadeRoot();

        $this->assertInstanceOf('RemoteControl\Manager', $remote);
    }
}
