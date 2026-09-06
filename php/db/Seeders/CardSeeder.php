<?php

declare(strict_types=1);

namespace Seeders;

use Enums\CardVariant;
use Factories\CardFactory;
use InvalidArgumentException;
use Seeders\Seeder;

class CardSeeder extends Seeder
{
    public static function run()
    {
        if (self::is_seeded(db_table: 'cards')) {
            echo "The cards are already seeded\n";
            return;
        }

        $source = APP_DIR . '/db/Fixtures/Card/';

        $variants = array_filter(
            scandir($source),
            fn($dir) => $dir !== '..' && $dir !== '.' && is_dir($source . '/' . $dir)
        );

        if (empty($variants)) {
            throw new InvalidArgumentException("Card variants are not created");
        }

        $factory = new CardFactory();

        foreach ($variants as $variant) {
            $variant = CardVariant::from($variant)->value;

            $fixtures = array_filter(
                scandir($source . '/' . $variant),
                fn($dir) => $dir !== '..' && $dir !== '.' && is_dir($source . '/' . $dir)
            );

            if (empty($fixtures)) {
                throw new InvalidArgumentException("Fixtures for $variant are not created");
            }

            foreach ($fixtures as $fixture) {
                $seed_dir = remove_extra_slashes($source . '/' . $variant . '/' . $fixture . '/');

                $name = read_or_throw($seed_dir . 'name.txt', "Couldn't extract card name from the file");
                $advice = read_or_throw($seed_dir . 'advice.txt', "Couldn't extract card advice from the file");
                $html = read_or_throw($seed_dir . 'theme.md', "Couldn't extract card theme from the file");
                $description = 'Описание карты';

                $card = $factory->create(
                    attrs: compact('name', 'advice', 'description'),
                    img_src: $seed_dir . 'front_image/',
                );

                $theme = $card->themes[0];
                $theme->html = $html;
                $theme->save();
            }
        }
        echo "Cards seeded.\n";
    }
}
