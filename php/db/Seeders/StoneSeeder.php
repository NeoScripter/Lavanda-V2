<?php

declare(strict_types=1);

namespace Seeders;

use Factories\StoneFactory;
use InvalidArgumentException;
use Seeders\Seeder;

class StoneSeeder extends Seeder
{
    public static function run()
    {
        if (self::is_seeded(db_table: 'stones')) {
            echo "The stones are already seeded\n";
            return;
        }

        $source = APP_DIR . '/db/Fixtures/Stone/';

        $fixtures = array_filter(
            scandir($source),
            fn($dir) => $dir !== '..' && $dir !== '.' && is_dir($source . '/' . $dir)
        );

        if (empty($fixtures)) {
            throw new InvalidArgumentException("Fixtures for stones are not created");
        }

        $factory = new StoneFactory();

        foreach ($fixtures as $fixture) {
            $seed_dir = remove_extra_slashes($source . '/' . $fixture . '/');

            $name = read_or_throw($seed_dir . 'name.txt', "Couldn't extract stone name from the file");
            $html = read_or_throw($seed_dir . 'html.md', "Couldn't extract stone html from the file");

            $factory->create(
                attrs: compact('name', 'html'),
                preview_src: $seed_dir . 'preview/',
                image_src: $seed_dir . 'image/'
            );
        }

        echo "Stones seeded.\n";
    }
}
