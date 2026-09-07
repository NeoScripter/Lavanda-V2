<?php

declare(strict_types=1);

namespace Seeders;

use Factories\ArticleFactory;
use InvalidArgumentException;
use Seeders\Seeder;

class ArticleSeeder extends Seeder
{
    public static function run()
    {
        if (self::is_seeded(db_table: 'articles')) {
            echo "The article are already seeded\n";
            return;
        }

        $source = APP_DIR . '/db/Fixtures/Article/';

        $fixtures = array_filter(
            scandir($source),
            fn($dir) => $dir !== '..' && $dir !== '.' && is_dir($source . '/' . $dir)
        );

        if (empty($fixtures)) {
            throw new InvalidArgumentException("Fixtures for articles are not created");
        }

        $factory = new ArticleFactory();

        foreach ($fixtures as $fixture) {
            $seed_dir = remove_extra_slashes($source . '/' . $fixture . '/');

            $name = read_or_throw($seed_dir . 'name.txt', "Couldn't extract article name from the file");
            $description = read_or_throw($seed_dir . 'description.txt', "Couldn't extract article description from the file");
            $html = read_or_throw($seed_dir . 'html.md', "Couldn't extract article html from the file");

            $factory->create(
                attrs: compact('name', 'description', 'html'),
                img_src: $seed_dir . 'image/',
            );
        }

        echo "Articles seeded.\n";
    }
}
