<?php

namespace RemoteControl\Tests\Feature;

use RemoteControl\Tests\TestCase;

class RemoteServiceProviderTest extends TestCase
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
    public function it_register_the_services()
    {
        $this->assertTrue($this->app->bound('remote-control'));

        $this->assertInstanceOf('RemoteControl\Manager', $this->app['remote-control']);
    }
}
