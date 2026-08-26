<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use Factories\CardFactory;
use Factories\ThemeFactory;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ThemeFactoryTest extends TestCase
{
    private ?ThemeFactory $factory = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new ThemeFactory();
    }

    #[Test]
    public function creates_theme_and_persists_to_database(): void
    {
        $cardF = new CardFactory();
        $card = $cardF->create();
        $theme = $this->factory->create([
            'themeable_id' => $card->id,
            'themeable_type' => $card->variant,
            'name' => 'Love'
        ]);

        $this->assertNotEmpty($theme->html);

        $rows = $this->hive->DB->exec('SELECT name from themes where id = ?', [$theme->id]);

        $this->assertNotEmpty($rows);
        $this->assertEquals($theme->name, $rows[0]['name']);
    }
}
