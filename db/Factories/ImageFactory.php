<?php

declare(strict_types=1);

namespace Factories;

use Http\Models\Image;
use InvalidArgumentException;
use RuntimeException;

class ImageFactory extends Factory
{
    public function create(array $attrs, string $src_dir)
    {
        if (!is_dir($src_dir)) {
            throw new InvalidArgumentException('Source directory is not a directory');
        }
        if (!array_key_exists('variant', $attrs)) {
            throw new InvalidArgumentException('No variant provided to the image factory');
        }
        if (!array_key_exists('imageable_type', $attrs)) {
            throw new InvalidArgumentException('No imageable_type provided to the image factory');
        }
        if (!array_key_exists('imageable_id', $attrs)) {
            throw new InvalidArgumentException('No imageable_id provided to the image factory');
        }

        $img_type = $attrs['imageable_type'];
        $img_id = $attrs['imageable_id'];
        $variant = $attrs['variant'];

        $files = read_dir_files($src_dir);

        if (empty($files)) {
            throw new InvalidArgumentException('Source directory provided to the image factory is empty');
        }

        $new_dir = \UPLOAD_DIR . "$img_type/" . uniqid() . '/';

        if (!is_dir($new_dir)) {
            mkdir($new_dir, 0755, true);
        }

        foreach ($files as $file) {
            if (!copy($src_dir . '/' . $file, $new_dir . '/' . $file)) {
                throw new RuntimeException("Failed to copy $file to $new_dir");
            }
        }

        $raw_matches = preg_grep('/(png|jpg|jpeg)$/', $files);

        if (empty($raw_matches)) {
            throw new RuntimeException("The original files don't contain png, jpg, or jpeg variant");
        }

        $raw_file = array_values($raw_matches)[0];

        $image = new Image();
        $image->src = to_public_url(remove_file_extention($new_dir . $raw_file));
        $image->alt = $attrs['alt'] ?? 'image';
        $image->variant = $variant;
        $image->imageable_id = $img_id;
        $image->imageable_type = $img_type;

        if (isset($attrs['locale'])) {
            $image->locale = $attrs['locale'];
        }

        $image->save();

        return $image;
    }
}
