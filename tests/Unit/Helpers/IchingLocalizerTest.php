<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use DB\SQL;
use Enums\ClonableType;
use Enums\Locale;
use Factories\IchingFactory;
use Http\Models\Iching;
use PHPUnit\Framework\Attributes\Test;
use Support\ModelLocalizer;
use Tests\TestCase;

final class IchingLocalizerTest extends TestCase
{
    protected null|SQL $db;

    protected function setUp(): void
    {
        parent::setUp();
        $this->db = \Base::instance()->get('DB');
    }

    #[Test]
    public function clones_ichings_to_another_locale_with_submodels(): void
    {
        $factory = new IchingFactory();

        for ($i = 0; $i < 5; $i++) {
            $factory->create(attrs: [
                'locale' => Locale::RUSSIAN->value
            ]);
        }

        $q = "SELECT count(id) FROM ichings";
        $prev_count = $this->db->exec($q)[0]['count'];

        $cloner = new ModelLocalizer(ClonableType::ICHING, Locale::ENGLISH);
        $cloner->clone_all();

        $new_count = $this->db->exec($q)[0]['count'];
        $all_variants_count = $this->db->exec("SELECT count(id) FROM ichings")[0]['count'];

        $this->assertEquals(expected: $prev_count * 2, actual: $new_count);
        $this->assertEquals(expected: $all_variants_count, actual: $new_count);

        $ichings = new Iching();
        $ichings->find();

        foreach ($ichings as $iching) {
            $iching->erase();
        }
    }

    #[Test]
    public function doesnt_clone_iching_when_already_present(): void
    {
        $factory = new IchingFactory();

        for ($i = 0; $i < 5; $i++) {
            $factory->create(attrs: ['locale' => Locale::RUSSIAN->value]);
        }

        $factory->create(attrs: ['locale' => Locale::ENGLISH->value]);

        $q = "SELECT count(id) FROM ichings";
        $prev_count = $this->db->exec($q)[0]['count'];

        $cloner = new ModelLocalizer(ClonableType::ICHING, Locale::ENGLISH);
        $cloner->clone_all();

        $new_count = $this->db->exec($q)[0]['count'];

        $this->assertEquals(expected: $prev_count, actual: $new_count);

        $ichings = new Iching();
        $ichings->find();

        foreach ($ichings as $iching) {
            $iching->erase();
        }
    }
}
