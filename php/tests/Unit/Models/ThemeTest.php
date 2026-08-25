<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use Factories\CardFactory;
use Factories\ThemeFactory;
use InvalidArgumentException;
use PDOException;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ThemeTest extends TestCase
{
    private ?ThemeFactory $factory = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new ThemeFactory();
    }

    #[Test]
    public function rejects_duplicate_theme_for_parent_on_create(): void
    {
        $cardF = new CardFactory();
        $card = $cardF->create();

        $this->expectException(InvalidArgumentException::class);

        for ($i = 0; $i < 2; $i++) {
            $this->factory->create([
                'themeable_id' => $card->id,
                'themeable_type' => $card->variant,
                'name' => 'General'
            ]);
        }
    }

    #[Test]
    public function rejects_duplicate_theme_for_parent_on_update(): void
    {
        $cardF = new CardFactory();
        $card = $cardF->create();

        $this->expectException(InvalidArgumentException::class);

        $themes = [];
        for ($i = 0; $i < 2; $i++) {
            $themes[] = $this->factory->create([
                'themeable_id' => $card->id,
                'themeable_type' => $card->variant,
                'name' => "General{$i}"
            ]);
        }

        foreach ($themes as $theme) {
            $theme->name = 'General';
            $theme->save();
        }
    }

    #[Test]
    public function enforces_unique_theme_per_parent_in_database(): void
    {
        $cardF = new CardFactory();
        $card = $cardF->create();

        $this->expectException(PDOException::class);

        $db = \Base::instance()->get('DB');
        for ($i = 0; $i < 2; $i++) {
            $db->exec(
                'INSERT INTO themes (themeable_id, themeable_type, name, html) VALUES (?, ?, ?, ?)',
                [$card->id, $card->variant, 'General', 'placeholde']
            );
        }
    }
    #[Test]
    public function returns_themes_associated_with_parent(): void
    {
        // $cardF = new CardFactory();
        // $card = $cardF->create();
        // $theme = $this->factory->create([
        //     'themeable_id' => $card->id,
        //     'themeable_type' => $card->variant,
        //     'name' => 'General'
        // ]);
        //
        // $this->assertNotEmpty($theme->html);
        //
        // $rows = $this->hive->DB->exec('SELECT name from themes where id = ?', [$theme->id]);
        //
        // $this->assertNotEmpty($rows);
        // $this->assertEquals($theme->name, $rows[0]['name']);
    }
}
