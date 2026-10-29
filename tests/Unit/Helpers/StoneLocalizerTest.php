<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use DB\SQL;
use Enums\ClonableType;
use Enums\ImageableType;
use Enums\Locale;
use Factories\StoneFactory;
use Http\Models\Stone;
use Http\Models\Theme;
use PHPUnit\Framework\Attributes\Test;
use Support\ModelLocalizer;
use Tests\TestCase;

final class StoneLocalizerTest extends TestCase
{
    protected null|SQL $db;

    protected function setUp(): void
    {
        parent::setUp();
        $this->db = \Base::instance()->get('DB');
    }

    #[Test]
    public function clones_stones_to_another_locale_with_submodels(): void
    {
        $imageable_type = ImageableType::STONE->value;
        $factory = new StoneFactory();

        for ($i = 0; $i < 5; $i++) {
            $factory->create(attrs: [
                'imageable_type' => $imageable_type,
                'locale' => Locale::RUSSIAN->value
            ]);
        }

        $q = "SELECT count(id) FROM stones";
        $prev_count = $this->db->exec($q)[0]['count'];

        $cloner = new ModelLocalizer(ClonableType::STONE, Locale::ENGLISH);
        $cloner->clone_all();

        $new_count = $this->db->exec($q)[0]['count'];
        $all_variants_count = $this->db->exec("SELECT count(id) FROM stones")[0]['count'];

        $this->assertEquals(expected: $prev_count * 2, actual: $new_count);
        $this->assertEquals(expected: $all_variants_count, actual: $new_count);

        $front_img_count =  $this->db->exec(
            "SELECT count(id) FROM images WHERE imageable_type = ? AND variant = 'preview'",
            $imageable_type
        )[0]['count'];

        $back_img_count =  $this->db->exec(
            "SELECT count(id) FROM images WHERE imageable_type = ? AND variant = 'image'",
            $imageable_type
        )[0]['count'];

        $this->assertEquals(expected: $new_count, actual: $back_img_count);
        $this->assertEquals(expected: $new_count, actual: $front_img_count);

        $stones = new Stone();
        $stones->find();

        foreach ($stones as $stone) {
            $stone->erase();
        }
    }

    #[Test]
    public function doesnt_clone_stone_when_already_present(): void
    {
        $factory = new StoneFactory();

        for ($i = 0; $i < 5; $i++) {
            $factory->create(attrs: ['locale' => Locale::RUSSIAN->value]);
        }

        $factory->create(attrs: ['locale' => Locale::ENGLISH->value]);

        $q = "SELECT count(id) FROM stones";
        $prev_count = $this->db->exec($q)[0]['count'];

        $cloner = new ModelLocalizer(ClonableType::STONE, Locale::ENGLISH);
        $cloner->clone_all();

        $new_count = $this->db->exec($q)[0]['count'];

        $this->assertEquals(expected: $prev_count, actual: $new_count);

        $stones = new Stone();
        $stones->find();

        foreach ($stones as $stone) {
            $stone->erase();
        }
    }
}
