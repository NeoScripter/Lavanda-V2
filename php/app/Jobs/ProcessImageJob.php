<?php

declare(strict_types=1);

namespace Jobs;

use Exception;
use Http\Models\Image;
use InvalidArgumentException;
use RuntimeException;

class ProcessImageJob extends Job
{
    public function handle(array $payload): void
    {
        $missing = array_diff([
            'parent_id',
            'parent_class',
            'field',
            'sizes',
            'files',
        ], array_keys($payload));

        if (! empty($missing)) {
            throw new InvalidArgumentException('Missing required payload keys: ' . implode(', ', $missing));
        }


        $parent_id      = $payload['parent_id'];
        $parent_class   = $payload['parent_class'];
        $field         = $payload['field'];
        $sizes         = $payload['sizes'];
        $files         = $payload['files'];
        $qnt           = $payload['qnt'] ?? null;

        if (!class_exists($parent_class)) {
            throw new InvalidArgumentException("Parent class does not exist: {$parent_class}");
        }

        $optimized = optimize_files(sizes: $sizes, files: $files, qnt: $qnt);

        if (empty($optimized)) {
            throw new RuntimeException("optimize_files() returned no files for {$parent_class} #{$parent_id}, field '{$field}'");
        }

        $parent = new $parent_class();
        $parent->load(['id = ?', $parent_id]);

        if ($parent->dry()) {
            throw new RuntimeException("Could not load {$parent_class} #{$parent_id}");
        }

        if ($qnt === 1 && isset($parent->{$field}) && is_object($parent->{$field})) {
            $parent->{$field}->erase();
            $parent->{$field} = null;
        }

        try {
            if ($qnt === 1) {
                $img = new Image();
                $img->copyFrom($optimized[0]);
                $img->save();
                $parent->{$field} = $img;
            } else {
                $ids = [];
                foreach ($optimized as $file) {
                    $img = new Image();
                    $img->copyFrom($file);
                    $img->save();
                    $ids[] = $img->id;
                }
                $parent->{$field} = $ids;
            }
            $parent->save();
        } catch (Exception $e) {
            $logger = new \Log(APP_DIR . '/storage/logs/worker.log');
            $logger->write("Failed processing image: {$e->getMessage()}");
        }

        echo 'Image processed successfully!' . PHP_EOL;
    }
}
