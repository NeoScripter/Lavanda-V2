<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use DB\SQL;
use Enums\CardVariant;
use Enums\ClonableType;
use Enums\ImageableType;
use Enums\Locale;
use Enums\ThemeableType;
use Factories\CardFactory;
use Http\Models\Card;
use Http\Models\Theme;
use PHPUnit\Framework\Attributes\Test;
use Support\ModelLocalizer;
use Tests\TestCase;

final class ModelLocalizerTest extends TestCase
{
    protected null|SQL $db;

    protected function setUp(): void
    {
        parent::setUp();
        $this->db = \Base::instance()->get('DB');
        $factory = new CardFactory();

        $factory->create(attrs: [
            'variant' => CardVariant::BONUS->value,
            'locale' => Locale::RUSSIAN->value
        ], with_back: true);

        for ($i = 0; $i < 4; $i++) {
            $factory->create(attrs: [
                'variant' => CardVariant::BONUS->value,
                'locale' => Locale::RUSSIAN->value
            ], with_back: false);
        }

        $themes = new Theme();
        $themes = $themes->find(["themeable_type = ?", ThemeableType::BONUS->value]);

        foreach ($themes as $theme) {
            $theme->html = 'New theme html';
            $theme->save();
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $cards = new Card();
        $cards->find();

        foreach ($cards as $card) {
            $card->erase();
        }
    }

    #[Test]
    public function clones_cards_to_another_locale_with_submodels(): void
    {
        $q = "SELECT count(id) FROM cards WHERE variant = ?";
        $prev_count = $this->db->exec($q, ClonableType::BONUS->value)[0]['count'];

        $total_themes = $this->db->exec(
            "SELECT count(id) FROM themes WHERE themeable_type = ? AND html != 'placeholder'",
            ThemeableType::BONUS->value
        )[0]['count'];

        $this->assertEquals(expected: $prev_count, actual: $total_themes);

        $cloner = new ModelLocalizer(ClonableType::BONUS, Locale::ENGLISH);
        $cloner->clone_all();

        $new_count = $this->db->exec($q, ClonableType::BONUS->value)[0]['count'];
        $all_variants_count = $this->db->exec("SELECT count(id) FROM cards")[0]['count'];

        $this->assertEquals(expected: $prev_count * 2, actual: $new_count);
        $this->assertEquals(expected: $all_variants_count, actual: $new_count);

        $new_themes = $this->db->exec(
            "SELECT count(id) FROM themes WHERE themeable_type = ? AND html != 'placeholder'",
            ThemeableType::BONUS->value
        )[0]['count'];

        $this->assertEquals(expected: $new_count, actual: $new_themes);

        $front_img_count =  $this->db->exec(
            "SELECT count(id) FROM images WHERE imageable_type = ? AND variant = 'front_image'",
            ImageableType::BONUS->value
        )[0]['count'];

        $back_img_count =  $this->db->exec(
            "SELECT count(id) FROM images WHERE imageable_type = ? AND variant = 'back_image'",
            ImageableType::BONUS->value
        )[0]['count'];

        $this->assertEquals(expected: 1, actual: $back_img_count);
        $this->assertEquals(expected: $new_count, actual: $front_img_count);
    }

    #[Test]
    public function doesnt_clone_card_when_already_present(): void
    {
        $factory = new CardFactory();

        $factory->create(attrs: [
            'variant' => CardVariant::BONUS->value,
            'locale' => Locale::ENGLISH->value
        ]);

        $q = "SELECT count(id) FROM cards";
        $prev_count = $this->db->exec($q)[0]['count'];

        $cloner = new ModelLocalizer(ClonableType::BONUS, Locale::ENGLISH);
        $cloner->clone_all();

        $new_count = $this->db->exec($q)[0]['count'];

        $this->assertEquals(expected: $prev_count, actual: $new_count);
    }
}
