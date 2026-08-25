<?php

declare(strict_types=1);

namespace Seeders;

use Factories\AudioMessageFactory;
use Seeders\Seeder;

class AudioMessageSeeder extends Seeder
{
    public static function run()
    {
        if (self::is_seeded(db_table: 'audio_messages')) {
            echo "The audio messages are already seeded.\n";
            return;
        }

        $factory = new AudioMessageFactory();
        for ($i = 0; $i < 10; $i++) {
            $factory->create();
        }

        echo "Audios seeded.\n";
    }
}
