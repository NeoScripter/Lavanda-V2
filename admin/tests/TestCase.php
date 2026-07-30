<?php

namespace Tests;

use DB\SQL;
use Http\Controllers\CliController;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected ?SQL $db = null;
    protected \Base $hive;

    protected function set_up(): void
    {
        parent::setUp();

        $this->hive = \Base::instance();
        // $this->hive->set('AUTOLOAD', APP_DIR . '/db/;');
        // $this->hive->run();

        $this->setup_database();

        $this->run_migrations();
    }

    protected function tear_down(): void
    {
        parent::tearDown();

        if ($this->db) {
            $this->db->disconnect();
            $this->db = null;
        }
    }

    private function setup_database(): void
    {
        $this->db = new \DB\SQL('sqlite::memory:');

        $this->hive->set('DB', $this->db);
    }

    private function run_migrations(): void
    {
        $hanlder = new CliController();
        $hanlder->migrate($this->hive);
    }
}
