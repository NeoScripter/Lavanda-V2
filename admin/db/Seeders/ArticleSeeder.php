<?php

declare(strict_types=1);

namespace Seeders;

use Factories\ImageFactory;
use Http\Models\Article;

class ArticleSeeder extends Seeder
{
    public static function run()
    {
        if (self::is_seeded(db_table: 'articles')) {
            echo "The articles are already seeded" . PHP_EOL;
            return;
        }

        $faker = \Faker\Factory::create('en_US');

        $article = new Article();

        for ($i = 0; $i < 20; $i++) {
            $image = ImageFactory::create("image-$i");

            $article->title = $faker->realText(50);
            $article->url = $faker->url();
            $article->image = $image;
            $article->save();
            $article->reset();
        }

        echo "Articles seeded.\n";
    }
}
