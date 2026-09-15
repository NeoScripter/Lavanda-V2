<?php

declare(strict_types=1);

namespace Jobs;

use Enums\AppEnv;
use Exception;
use Http\Models\Image;
use RuntimeException;
use Support\ImageHandler;

class ProcessImageJob extends Job
{
    public function handle(array $payload): void
    {
        $image_id = $payload['image_id'];
        $file = $payload['file'];
        $sizes = $payload['sizes'];

        $src = ImageHandler::make()
            ->process(src: $file, sizes: $sizes);

        try {
            $db = \Base::instance()->get('DB');

            $prev = $db->exec('SELECT src FROM images WHERE id = ?', [$image_id]);

            if (empty($prev)) {
                throw new RuntimeException("Could not find the image with id: {$image_id}");
            }

            $prev_src = $prev[0]['src'];

            $db->exec('UPDATE images SET src = ? WHERE id = ?', [$src, $image_id]);

            purge_files($prev_src);
        } catch (Exception $e) {
            if (! AppEnv::is(AppEnv::TESTING)) {
                echo ("Failed processing image: {$e->getMessage()}");
            }
        }

        if (! AppEnv::is(AppEnv::TESTING)) {
            echo 'Image processed successfully!' . PHP_EOL;
        }
    }
}
