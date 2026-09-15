<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use Enums\CardVariant;
use Enums\Locale;
use Factories\CardFactory;
use Factories\ThemeFactory;
use Http\Models\FlipCard;
use Http\Models\Image;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class CardTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    #[Test]
    public function generates_card_backs_on_migration(): void
    {
        $db = $this->hive->get('DB');

        $variant_num = count(CardVariant::values());

        $res = $db->exec("SELECT count(*) FROM images");
        $this->assertEquals($variant_num, $res[0]['count'], 'No view found');
    }

    #[Test]
    public function deletes_only_front_image_when_deleted(): void
    {
        $factory = new CardFactory();
        $card = $factory->create(with_back: true);

        $flip_card = (new FlipCard())->load(['id=?', $card->id]);
        $flip_card = $flip_card->to_resource();

        $card->erase();
        $front_image = new Image();
        $front_image->load(['id=?', $flip_card['front_image']['id']]);
        $back_image = new Image();
        $back_image->load(['id=?', $flip_card['back_image']['id']]);

        $this->assertTrue($front_image->dry());
        $this->assertNotTrue($back_image->dry());
    }

    #[Test]
    public function creates_general_theme_by_default(): void
    {
        $cardF = new CardFactory();
        $locale = Locale::RUSSIAN->value;

        foreach (CardVariant::values() as $card_variant) {
            $cardF->create(['variant' => $card_variant, 'locale' => $locale]);
        }

        $db = $this->hive->get('DB');

        $variant_num = count(CardVariant::values());

        $res = $db->exec("SELECT count(*) FROM themes");
        $this->assertEquals($variant_num, $res[0]['count'], 'Themes were not created');

        $row = $db->exec("SELECT name FROM themes");
        $this->assertContainsEquals('Общая', $row[0], "Themes don't have the right names");
    }

    #[Test]
    public function cascades_themes_on_delete(): void
    {
        $cardF = new CardFactory();

        $cards = [];
        foreach (CardVariant::values() as $card_variant) {
            $cards[] = $cardF->create(['variant' => $card_variant]);
        }

        $db = $this->hive->get('DB');

        $variant_num = count(CardVariant::values());

        $res = $db->exec("SELECT count(*) FROM themes");
        $this->assertEquals($variant_num, $res[0]['count'], 'Themes were not created');

        foreach ($cards as $card) {
            $card->erase();
        }

        $res = $db->exec("SELECT count(*) FROM themes");
        $this->assertEquals(0, $res[0]['count'], 'Themes were not deleted');
    }

    #[Test]
    public function fetches_associated_themes(): void
    {
        $cardF = new CardFactory();
        $card = $cardF->create();

        $themeF = new ThemeFactory();
        $names = ['Love', 'Career'];

        foreach ($names as $name) {
            $themeF->create([
                'themeable_id' => $card->id,
                'themeable_type' => $card->variant,
                'name' => $name,
            ]);
        }

        $themes = $card->themes;

        $this->assertNotNull($themes);
        $this->assertCount(3, $themes);
    }
}
