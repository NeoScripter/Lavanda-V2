<?php

declare(strict_types=1);

namespace Factories;

use Http\Models\Image;
use Support\ImageHandler;

class ImageFactory
{
    public static function create(string $name)
    {
        $image_path =  APP_DIR . '/public/assets/imgs/shared/placeholder.webp';

        if (!file_exists($image_path)) {
            throw new \RuntimeException("Placeholder image not found: $image_path");
        }

        $new_dir = UPLOAD_DIR . "news-$name/";
        if (!is_dir($new_dir)) {
            mkdir($new_dir, 0755, true);
        }

        $image = new Image();
        foreach (['image-mb.webp', 'image-mb2x.webp', 'image-mb3x.webp'] as $file) {
            if (!copy($image_path, $new_dir . $file)) {
                throw new \RuntimeException("Failed to copy $file to $new_dir");
            }
        }

        $image->src = ImageHandler::normalize_path($new_dir . 'image');
        $image->alt = 'placeholder';
        $image->save();

        return $image;
    }
}
