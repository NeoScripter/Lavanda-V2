<?php

declare(strict_types=1);

namespace Seeders;

use Factories\ArticleFactory;
use Seeders\Seeder;

class ArticleSeeder extends Seeder
{
    public static function run()
    {
        if (self::is_seeded(db_table: 'articles')) {
            echo "The article are already seeded\n";
            return;
        }

        $factory = new ArticleFactory();
        for ($i = 0; $i < 10; $i++) {
            $factory->create();
        }

        echo "Articles seeded.\n";
    }
}
