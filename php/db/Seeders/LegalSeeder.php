<?php

declare(strict_types=1);

namespace Seeders;

use Enums\LegalSlug;
use Enums\Locale;
use Factories\LegalFactory;
use InvalidArgumentException;
use Seeders\Seeder;

class LegalSeeder extends Seeder
{
    public static function run()
    {
        if (self::is_seeded(db_table: 'legals')) {
            echo "The legal are already seeded\n";
            return;
        }

        $source = APP_DIR . '/db/Fixtures/Legal/';

        $fixtures = array_filter(
            scandir($source),
            fn($dir) => $dir !== '..' && $dir !== '.' && is_dir($source . '/' . $dir)
        );

        if (empty($fixtures)) {
            throw new InvalidArgumentException("Fixtures for legals are not created");
        }

        $factory = new LegalFactory();


        foreach (Locale::values() as $locale) {

            foreach ($fixtures as $fixture) {
                $seed_dir = remove_extra_slashes($source . '/' . $fixture . '/');

                $label = read_or_throw($seed_dir . 'slug.txt', "Couldn't extract legal slug from the file");
                $html = read_or_throw($seed_dir . 'html.md', "Couldn't extract legal html from the file");

                $slug = match ($label) {
                    "consent" => LegalSlug::CONSENT->value,
                    "policy" => LegalSlug::POLICY->value,
                };

                $factory->create(
                    attrs: compact('slug', 'html', 'locale'),
                );
            }
        }

        echo "Legals seeded.\n";
    }
}
