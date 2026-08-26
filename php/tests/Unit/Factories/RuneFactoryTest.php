<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use Factories\RuneFactory;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class RuneFactoryTest extends TestCase
{
    private ?RuneFactory $factory = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new RuneFactory();
    }

    #[Test]
    public function creates_rune_and_persists_to_database(): void
    {
        $rune = $this->factory->create();

        $this->assertNotEmpty($rune->name);

        $rows = $this->hive->DB->exec('SELECT name from runes where id = ?', [$rune->id]);

        $this->assertNotEmpty($rows);
        $this->assertEquals($rune->name, $rows[0]['name']);
    }

    #[Test]
    public function creates_rune_together_with_theme(): void
    {
        $rune = $this->factory->create();

        $this->assertNotEmpty($rune->name);

        $actual_count = count($rune->themes);

        $this->assertEquals(actual: $actual_count, expected: 1);
    }
}

