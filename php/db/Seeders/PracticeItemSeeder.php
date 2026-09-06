<?php

declare(strict_types=1);

namespace Seeders;

use Factories\PracticeItemFactory;
use InvalidArgumentException;
use Seeders\Seeder;

class PracticeItemSeeder extends Seeder
{
    public static function run()
    {
        if (self::is_seeded(db_table: 'practice_items')) {
            echo "The practice items are already seeded\n";
            return;
        }

        $source = APP_DIR . '/db/Fixtures/PracticeItem/';

        $fixtures = array_filter(
            scandir($source),
            fn($dir) => $dir !== '..' && $dir !== '.' && is_dir($source . '/' . $dir)
        );

        if (empty($fixtures)) {
            throw new InvalidArgumentException("Fixtures for items are not created");
        }

        $factory = new PracticeItemFactory();

        foreach ($fixtures as $fixture) {
            $seed_dir = remove_extra_slashes($source . '/' . $fixture . '/');

            $title = read_or_throw($seed_dir . 'title.txt', "Couldn't extract item title from the file");
            $abstract = read_or_throw($seed_dir . 'abstract.txt', "Couldn't extract item abstract from the file");
            $description = read_or_throw($seed_dir . 'description.txt', "Couldn't extract item description from the file");
            $faqs = read_or_throw($seed_dir . 'faqs.md', "Couldn't extract item faqs from the file");

            $factory->create(
                attrs: compact('description', 'faqs', 'abstract', 'title'),
                file: $seed_dir . 'file/file.jpg',
                img_src: $seed_dir . 'image'
            );
        }

        echo "PracticeItems seeded.\n";
    }
}
