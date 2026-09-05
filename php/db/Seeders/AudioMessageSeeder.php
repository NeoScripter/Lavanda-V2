<?php

declare(strict_types=1);

namespace Seeders;

use Factories\AudioMessageFactory;
use InvalidArgumentException;
use Seeders\Seeder;

class AudioMessageSeeder extends Seeder
{
    public static function run()
    {
        if (self::is_seeded(db_table: 'audio_messages')) {
            echo "The audio messages are already seeded.\n";
            return;
        }

        $source = APP_DIR . '/db/Fixtures/AudioMessage/';

        $fixtures = array_filter(
            scandir($source),
            fn($dir) => $dir !== '..' && $dir !== '.' && is_dir($source . '/' . $dir)
        );

        if (empty($fixtures)) {
            throw new InvalidArgumentException("Fixtures for audios are not created");
        }

        $factory = new AudioMessageFactory();

        foreach ($fixtures as $fixture) {
            $seed_dir = remove_extra_slashes($source . '/' . $fixture . '/');

            $description = read_or_throw($seed_dir . 'description.txt', "Couldn't extract audio description from the file");

            $factory->create(
                attrs: compact('description'),
                file: $seed_dir . 'audio.mp3',
            );
        }

        echo "Audios seeded.\n";
    }
}
