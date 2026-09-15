<?php

declare(strict_types=1);

namespace Seeders;

use Enums\ThemeableType;
use Factories\RuneFactory;
use Http\Models\Theme;
use InvalidArgumentException;
use Seeders\Seeder;

class RuneSeeder extends Seeder
{
    public static function run()
    {
        if (self::is_seeded(db_table: 'runes')) {
            echo "The runes are already seeded\n";
            return;
        }

        $source = APP_DIR . '/db/Fixtures/Rune/';

        $factory = new RuneFactory();

        $fixtures = array_filter(
            scandir($source),
            fn($dir) => $dir !== '..' && $dir !== '.' && is_dir($source . '/' . $dir)
        );

        if (empty($fixtures)) {
            throw new InvalidArgumentException("Rune fixtures are not created");
        }

        foreach ($fixtures as $fixture) {
            $seed_dir = remove_extra_slashes($source . '/' . $fixture . '/');

            $name = read_or_throw($seed_dir . 'name.txt', "Couldn't extract rune name from the file");
            $advice = read_or_throw($seed_dir . 'advice.txt', "Couldn't extract rune advice from the file");

            $rune = $factory->seed(
                attrs: compact('name', 'advice'),
                front_img_src: $seed_dir . 'front_image/',
                back_img_src: $seed_dir . 'back_image/',
            );

            $theme_fixtures = array_filter(
                scandir($seed_dir . 'themes/'),
                fn($dir) => $dir !== '..' && $dir !== '.' && is_dir($seed_dir . 'themes/' . $dir)
            );

            if (empty($theme_fixtures)) {
                throw new InvalidArgumentException("Rune theme fixtures are not created");
            }

            $rune->themes[0]->erase();

            foreach ($theme_fixtures as $theme_fixture) {
                $theme_dir = remove_extra_slashes($seed_dir . '/themes/' . $theme_fixture . '/');

                $name = read_or_throw($theme_dir . 'name.txt', "Couldn't extract theme name from the file");
                $html = read_or_throw($theme_dir . 'html.md', "Couldn't extract theme html from the file");

                $theme_attrs = [
                    'name' => $name,
                    'themeable_type' => ThemeableType::RUNE->value,
                    'themeable_id' => $rune->id,
                    'html' => $html
                ];

                $theme = new Theme();
                $theme->copyfrom($theme_attrs);
                $theme->save();
            }
        }

        echo "Runes seeded.\n";
    }
}
