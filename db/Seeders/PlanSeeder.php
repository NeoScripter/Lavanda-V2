<?php

declare(strict_types=1);

namespace Seeders;

use Enums\PlanSlug;
use Http\Models\Plan;
use Seeders\Seeder;

class PlanSeeder extends Seeder
{
    public static function run()
    {
        if (self::is_seeded(db_table: 'plans')) {
            echo "The plans are already seeded\n";
            return;
        }

        $prices = [
            PlanSlug::ONE_TIME->value => 990,
            PlanSlug::MONTHLY->value => 1990,
            PlanSlug::YEARLY->value => 9990,
            PlanSlug::PERSONAL->value => 9990,
        ];

        foreach (PlanSlug::values() as $slug) {
            $plan = new Plan();
            $plan->slug = $slug;
            $plan->price = $prices[$slug];
            $plan->save();
        }

        echo "Plans seeded.\n";
    }
}
