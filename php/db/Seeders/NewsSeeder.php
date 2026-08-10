<?php

declare(strict_types=1);

namespace Seeders;

use Factories\ImageFactory;
use Http\Models\News;

class NewsSeeder extends Seeder
{
    public static function run()
    {
        if (self::is_seeded(db_table: 'news')) {
            echo "The news are already seeded" . PHP_EOL;
            return;
        }

        $faker = \Faker\Factory::create('en_US');

        $news = new News();

        for ($i = 0; $i < 20; $i++) {
            $image = ImageFactory::create("image-$i");

            $news->title = $faker->realText(100);
            $news->summary = $faker->realText(300);
            $news->body = $faker->realText(300);
            $news->image = $image;
            $news->save();
            $news->reset();
        }

        echo "News seeded.\n";
    }
}
