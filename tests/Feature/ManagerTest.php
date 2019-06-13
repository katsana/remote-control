<?php

namespace RemoteControl\Tests\Feature;

use RemoteControl\Manager;
use RemoteControl\Tests\TestCase;

class ManagerTest extends TestCase
{
    /**
     * Teardown the test environment.
     */
    protected function tearDown(): void
    {
        Manager::$runsMigrations = true;
    }

    /** @test */
    public function it_can_disable_exporting_migrations()
    {
        $this->assertTrue(Manager::$runsMigrations);

        Manager::ignoreMigrations();

        $this->assertFalse(Manager::$runsMigrations);
    }
}
