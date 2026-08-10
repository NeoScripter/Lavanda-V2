<?php

declare(strict_types=1);

namespace Seeders;

use Factories\ReportFactory;
use Seeders\Seeder;

class ReportSeeder extends Seeder
{
    public static function run()
    {
        if (self::is_seeded(db_table: 'reports')) {
            echo 'The reports are already seeded';
            return;
        }

        $items = [
            [
                'src' => '/assets/files/budget/report-2020.pdf',
                'title' => '2020 Annual Report',
                'priority' => 6
            ],
            [
                'src' => '/assets/files/budget/audit-2020.pdf',
                'title' => '2020 Audit Report',
                'priority' => 5
            ],
            [
                'src' => '/assets/files/budget/report-2019.pdf',
                'title' => '2019 Annual Report',
                'priority' => 4
            ],
            [
                'src' => '/assets/files/budget/audit-2019.pdf',
                'title' => '2019 Audit Report',
                'priority' => 3
            ],
            [
                'src' => '/assets/files/budget/report-2018.pdf',
                'title' => '2018 Annual Report',
                'priority' => 2
            ],
            [
                'src' => '/assets/files/budget/audit-2018.pdf',
                'title' => '2018 Audit Report',
                'priority' => 1
            ],
        ];

        foreach ($items as $item) {
            ReportFactory::create($item);
        }

        echo "Reports seeded.\n";
    }
}
