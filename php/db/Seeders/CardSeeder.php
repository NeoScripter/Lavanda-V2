<?php

declare(strict_types=1);

namespace Seeders;

use Factories\ReportFactory;
use Seeders\Seeder;

class CardSeeder extends Seeder
{
    public static function run()
    {
        if (self::is_seeded(db_table: 'cards')) {
            echo 'The cards are already seeded';
            return;
        }


        foreach ($items as $item) {
            ReportFactory::create($item);
        }

        echo "Cards seeded.\n";
    }
}
