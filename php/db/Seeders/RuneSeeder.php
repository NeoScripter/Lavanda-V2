<?php

declare(strict_types=1);

namespace Seeders;

use Factories\RuneFactory;
use Seeders\Seeder;

class RuneSeeder extends Seeder
{
    public static function run()
    {
        if (self::is_seeded(db_table: 'runes')) {
            echo 'The runes are already seeded';
            return;
        }

        $factory = new RuneFactory();
        for ($i = 0; $i < 10; $i++) {
            $factory->create();
        }

        echo "Runes seeded.\n";
    }
}
