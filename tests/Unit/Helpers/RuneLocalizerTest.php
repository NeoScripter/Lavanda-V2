<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use DB\SQL;
use Enums\ClonableType;
use Enums\Locale;
use Enums\ThemeableType;
use Factories\RuneFactory;
use Http\Models\Rune;
use Http\Models\Theme;
use PHPUnit\Framework\Attributes\Test;
use Support\ModelLocalizer;
use Tests\TestCase;

final class RuneLocalizerTest extends TestCase
{
    protected null|SQL $db;

    protected function setUp(): void
    {
        parent::setUp();
        $this->db = \Base::instance()->get('DB');
    }

    #[Test]
    public function clones_runes_to_another_locale_with_submodels(): void
    {
        $themeable_type = ThemeableType::RUNE->value;
        $factory = new RuneFactory();

        for ($i = 0; $i < 5; $i++) {
            $factory->create(attrs: [
                'themeable_type' => $themeable_type,
                'locale' => Locale::RUSSIAN->value
            ]);
        }

        $themes = new Theme();
        $themes = $themes->find(["themeable_type = ?", $themeable_type]);

        foreach ($themes as $theme) {
            $theme->html = 'New theme html';
            $theme->save();
        }

        $q = "SELECT count(id) FROM runes";
        $prev_count = $this->db->exec($q)[0]['count'];

        $total_themes = $this->db->exec(
            "SELECT count(id) FROM themes WHERE themeable_type = ? AND html != 'placeholder'",
            $themeable_type
        )[0]['count'];

        $this->assertEquals(expected: $prev_count, actual: $total_themes);

        $cloner = new ModelLocalizer(ClonableType::RUNE, Locale::ENGLISH);
        $cloner->clone_all();

        $new_count = $this->db->exec($q)[0]['count'];
        $all_variants_count = $this->db->exec("SELECT count(id) FROM runes")[0]['count'];

        $this->assertEquals(expected: $prev_count * 2, actual: $new_count);
        $this->assertEquals(expected: $all_variants_count, actual: $new_count);

        $new_themes = $this->db->exec(
            "SELECT count(id) FROM themes WHERE themeable_type = ? AND html != 'placeholder'",
            $themeable_type
        )[0]['count'];

        $this->assertEquals(expected: $new_count, actual: $new_themes);

        $front_img_count =  $this->db->exec(
            "SELECT count(id) FROM images WHERE imageable_type = ? AND variant = 'front_image'",
            $themeable_type
        )[0]['count'];

        $back_img_count =  $this->db->exec(
            "SELECT count(id) FROM images WHERE imageable_type = ? AND variant = 'back_image'",
            $themeable_type
        )[0]['count'];

        $this->assertEquals(expected: $new_count, actual: $back_img_count);
        $this->assertEquals(expected: $new_count, actual: $front_img_count);

        $runes = new Rune();
        $runes->find();

        foreach ($runes as $rune) {
            $rune->erase();
        }
    }

    #[Test]
    public function doesnt_clone_rune_when_already_present(): void
    {
        $factory = new RuneFactory();

        for ($i = 0; $i < 5; $i++) {
            $factory->create(attrs: ['locale' => Locale::RUSSIAN->value]);
        }

        $themes = new Theme();
        $themes = $themes->find(["themeable_type = ?", ThemeableType::RUNE->value]);

        foreach ($themes as $theme) {
            $theme->html = 'New theme html';
            $theme->save();
        }

        $factory->create(attrs: ['locale' => Locale::ENGLISH->value]);

        $q = "SELECT count(id) FROM runes";
        $prev_count = $this->db->exec($q)[0]['count'];

        $cloner = new ModelLocalizer(ClonableType::RUNE, Locale::ENGLISH);
        $cloner->clone_all();

        $new_count = $this->db->exec($q)[0]['count'];

        $this->assertEquals(expected: $prev_count, actual: $new_count);

        $runes = new Rune();
        $runes->find();

        foreach ($runes as $rune) {
            $rune->erase();
        }
    }
}
