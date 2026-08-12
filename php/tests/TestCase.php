<?php

namespace Tests;

use DB\SQL;
use Http\Controllers\CliController;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected ?SQL $db = null;
    protected \Base $hive;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hive = \Base::instance();
        $this->hive->set('app_env', 'test');

        $this->run_migrations();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $hanlder = new CliController();
        $hanlder->drop($this->hive);
    }

    private function run_migrations(): void
    {
        $hanlder = new CliController();
        $hanlder->fresh($this->hive);
    }
}
