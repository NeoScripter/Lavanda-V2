<?php

declare(strict_types=1);

namespace Seeders;

abstract class Seeder
{
    protected static function is_seeded(string $db_table): bool
    {
        $hive = \Base::instance();

        $count = $hive->DB->exec(
            "SELECT COUNT(id) FROM $db_table",
        );

        $is_seeded = (! empty($count)) && $count[0]['count'] > 0;

        return $is_seeded;
    }
}
