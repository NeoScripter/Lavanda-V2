<?php

declare(strict_types=1);

namespace Tests\Unit\Seeders;

use PHPUnit\Framework\Attributes\Test;
use Seeders\StoneSeeder;
use Tests\TestCase;

final class StoneSeederTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    #[Test]
    public function successfully_creates_stones_from_fixture_files(): void
    {
        (new StoneSeeder())->run();

        $db = $this->hive->get('DB');

        $res = $db->exec("SELECT count(*) FROM stones");
        $this->assertEquals(1, $res[0]['count'], 'Stones were not created');

    }
}
