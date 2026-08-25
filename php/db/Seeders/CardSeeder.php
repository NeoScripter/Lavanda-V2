<?php

declare(strict_types=1);

namespace Seeders;

use Enums\CardVariant;
use Factories\CardFactory;
use Seeders\Seeder;

class CardSeeder extends Seeder
{
    public static function run()
    {
        if (self::is_seeded(db_table: 'cards')) {
            echo "The cards are already seeded\n";
            return;
        }

        foreach (CardVariant::values() as $variant) {

            $factory = new CardFactory();
            for ($i = 0; $i < 10; $i++) {
                $factory->create(attrs: ['variant' => $variant]);
            }
        }

        echo "Cards seeded.\n";
    }
}
