<?php

declare(strict_types=1);

namespace Seeders;

use Factories\AffirmationFactory;
use Seeders\Seeder;

class AffirmationSeeder extends Seeder
{
    public static function run()
    {
        if (self::is_seeded(db_table: 'affirmations')) {
            echo "The affirmations are already seeded\n";
            return;
        }

        $factory = new AffirmationFactory();
        $topics = ['Мама и малыш', 'Карьера, бизнес', 'Гармония'];

        foreach ($topics as $topic) {
            for ($i = 0; $i < 10; $i++) {
                $factory->create(compact('topic'));
            }
            
        }

        echo "Affirmations seeded.\n";
    }
}
