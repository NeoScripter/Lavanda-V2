<?php

declare(strict_types=1);

namespace Seeders;

use Factories\AffirmationFactory;
use InvalidArgumentException;
use Seeders\Seeder;

class AffirmationSeeder extends Seeder
{

    public static function run()
    {
        if (self::is_seeded(db_table: 'affirmations')) {
            echo "The affirmations are already seeded\n";
            return;
        }

        $source = APP_DIR . '/db/Fixtures/Affirmation/';

        $fixtures = array_filter(
            scandir($source),
            fn($dir) => $dir !== '..' && $dir !== '.' && is_dir($source . '/' . $dir)
        );

        if (empty($fixtures)) {
            throw new InvalidArgumentException("Fixtures for affirmations are not created");
        }

        $factory = new AffirmationFactory();

        foreach ($fixtures as $fixture) {
            $seed_dir = remove_extra_slashes($source . '/' . $fixture . '/');

            $topic = read_or_throw($seed_dir . 'topic.txt', "Couldn't extract affirmation topic from the file");
            $quote = read_or_throw($seed_dir . 'quote.txt', "Couldn't extract affirmation quote from the file");

            $factory->seed(attrs: compact('topic', 'quote'));
        }

        echo "Affirmations seeded.\n";
    }
}
