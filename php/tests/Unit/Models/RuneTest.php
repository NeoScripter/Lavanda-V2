<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use Enums\Locale;
use Factories\RuneFactory;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class RuneTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    #[Test]
    public function creates_general_theme_by_default(): void
    {
        $runeF = new RuneFactory();
        $locale = Locale::ENGLISH->value;

        $runeF->create(['locale' => $locale]);

        $db = $this->hive->get('DB');

        $res = $db->exec("SELECT count(*) FROM themes");
        $this->assertEquals(1, $res[0]['count'], 'Themes were not created');

        $row = $db->exec("SELECT name FROM themes");
        $this->assertContainsEquals('General', $row[0], "Themes don't have the right names");
    }

    #[Test]
    public function cascades_themes_on_delete(): void
    {
        $db = $this->hive->get('DB');
        $runeF = new RuneFactory();

        $rune = $runeF->create();

        $res = $db->exec("SELECT count(*) FROM themes");

        $this->assertEquals(1, $res[0]['count'], 'Themes were not created');

        $rune->erase();

        $res = $db->exec("SELECT count(*) FROM themes");
        $this->assertEquals(0, $res[0]['count'], 'Themes were not deleted');
    }
}
