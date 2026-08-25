<?php

declare(strict_types=1);

namespace Seeders;

use Factories\FAQFactory;
use Seeders\Seeder;

class FAQSeeder extends Seeder
{
    public static function run()
    {
        if (self::is_seeded(db_table: 'faqs')) {
            echo "The faqs are already seeded\n";
            return;
        }

        $factory = new FAQFactory();
        for ($i = 0; $i < 10; $i++) {
            $factory->create();
        }

        echo "FAQs seeded.\n";
    }
}
