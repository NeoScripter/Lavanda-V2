<?php

declare(strict_types=1);

namespace Seeders;

use Factories\PracticeItemFactory;
use Seeders\Seeder;

class PracticeItemSeeder extends Seeder
{
    public static function run()
    {
        if (self::is_seeded(db_table: 'practice_items')) {
            echo "The practice items are already seeded\n";
            return;
        }

        $factory = new PracticeItemFactory();
        for ($i = 0; $i < 10; $i++) {
            $factory->create();
        }

        echo "PracticeItems seeded.\n";
    }
}
