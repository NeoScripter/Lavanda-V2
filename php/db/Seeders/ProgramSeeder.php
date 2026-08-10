<?php

declare(strict_types=1);

namespace Seeders;

use Enums\ProgramTitle;
use Factories\ImageFactory;
use Http\Models\Program;

class ProgramSeeder extends Seeder
{
    public static function run()
    {
        if (self::is_seeded(db_table: 'programs')) {
            echo "The programs are already seeded" . PHP_EOL;
            return;
        }

        foreach (ProgramTitle::values() as $title) {

            $program = new Program();
            $program->title = $title;

            $ids = [];
            for ($i = 0; $i < 20; $i++) {
                $image = ImageFactory::create("image-$i");
                $ids[] = $image->id;
            }
            $program->gallery = $ids;
            $program->save();
        }

        echo "Programs seeded.\n";
    }
}
