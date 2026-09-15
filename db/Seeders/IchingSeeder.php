<?php

declare(strict_types=1);

namespace Seeders;

use Factories\IchingFactory;
use InvalidArgumentException;
use Seeders\Seeder;

class IchingSeeder extends Seeder
{
    public static function run()
    {
        if (self::is_seeded(db_table: 'ichings')) {
            echo "The ichings are already seeded\n";
            return;
        }

        $source = APP_DIR . '/db/Fixtures/Iching/';

        $fixtures = array_filter(
            scandir($source),
            fn($dir) => $dir !== '..' && $dir !== '.' && is_dir($source . '/' . $dir)
        );

        if (empty($fixtures)) {
            throw new InvalidArgumentException("Fixtures for ichings are not created");
        }

        $factory = new IchingFactory();

        foreach ($fixtures as $fixture) {
            $seed_dir = remove_extra_slashes($source . '/' . $fixture . '/');

            $bitmask = read_or_throw($seed_dir . 'bitmask.txt', "Couldn't extract iching bitmask from the file");
            $number = read_or_throw($seed_dir . 'number.txt', "Couldn't extract iching number from the file");
            $description = read_or_throw($seed_dir . 'description.md', "Couldn't extract iching description from the file");

            $factory->seed(attrs: compact('bitmask', 'number', 'description'));
        }

        echo "Ichings seeded.\n";
    }
}
