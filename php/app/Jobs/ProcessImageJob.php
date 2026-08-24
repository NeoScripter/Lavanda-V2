<?php

declare(strict_types=1);

namespace Jobs;

use Enums\AppEnv;
use Exception;
use Http\Models\Image;
use InvalidArgumentException;
use RuntimeException;

class ProcessImageJob extends Job
{
    public function handle(array $payload): void
    {
        $missing = array_diff([
            'imageable_id',
            'imageable_type',
            'variant',
            'sizes',
            'files',
        ], array_keys($payload));

        if (! empty($missing)) {
            throw new InvalidArgumentException('Missing required payload keys: ' . implode(', ', $missing));
        }

        $imageable_id = $payload['imageable_id'];
        $imageable_type = $payload['imageable_type'];
        $variant = $payload['variant'];
        $sizes = $payload['sizes'];
        $files = $payload['files'];
        $qnt = $payload['qnt'] ?? null;

        $optimized = optimize_files(sizes: $sizes, files: $files, qnt: $qnt);

        if ($qnt === 1) {
            $optimized = array_slice($optimized, 0, 1);
        }

        if (empty($optimized)) {
            throw new RuntimeException("optimize_files() returned no files for {$imageable_type} #{$imageable_id}");
        }

        try {
            // TODO: add limit to the image processing
            $stale_imgs = new Image();
            $stale_imgs = $stale_imgs->find(['imageable_type = ? AND imageable_id = ? AND variant = ?', $imageable_type, $imageable_id, $variant]);

            if (! empty($stale_imgs)) {
                foreach ($stale_imgs as $img) {
                    $img->erase();
                }
            }

            foreach ($optimized as $file) {
                $img = new Image();
                $img->copyFrom([
                    ...$file,
                    ...compact('imageable_id', 'imageable_type', 'variant')
                ]);

                $img->save();
            }
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
