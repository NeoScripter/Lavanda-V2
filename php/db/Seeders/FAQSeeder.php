<?php

declare(strict_types=1);

namespace Seeders;

use Factories\FAQFactory;
use InvalidArgumentException;
use Seeders\Seeder;

class FAQSeeder extends Seeder
{
    public static function run()
    {
        if (self::is_seeded(db_table: 'faqs')) {
            echo "The faqs are already seeded\n";
            return;
        }

        $source = APP_DIR . '/db/Fixtures/FAQ/';

        $fixtures = array_filter(
            scandir($source),
            fn($dir) => $dir !== '..' && $dir !== '.' && is_dir($source . '/' . $dir)
        );

        if (empty($fixtures)) {
            throw new InvalidArgumentException("Fixtures for faqs are not created");
        }

        $factory = new FAQFactory();

        foreach ($fixtures as $fixture) {
            $seed_dir = remove_extra_slashes($source . '/' . $fixture . '/');

            $question = read_or_throw($seed_dir . 'question.txt', "Couldn't extract faq question from the file");
            $answer = read_or_throw($seed_dir . 'answer.md', "Couldn't extract faq answer from the file");

            $factory->create(attrs: compact('question', 'answer'));
        }

        echo "FAQs seeded.\n";
    }
}
