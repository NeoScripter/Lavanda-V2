<?php

declare(strict_types=1);

namespace Factories;

use Http\Models\Image;
use Support\ImageHandler;

class ImageFactory
{
    private string $template = APP_DIR . '/db/Fixtures/Image/placeholder.png';

    public function create(string $name)
    {
        $files = $this->get_template_variants();

        $new_dir = \UPLOAD_DIR . "news-$name/";
        if (!is_dir($new_dir)) {
            mkdir($new_dir, 0755, true);
        }

        $image = new Image();
        foreach (['image-mb.webp', 'image-mb2x.webp', 'image-mb3x.webp'] as $file) {
            if (!copy($this->template, $new_dir . $file)) {
                throw new \RuntimeException("Failed to copy $file to $new_dir");
            }
        }

        $image->src = ImageHandler::normalize_path($new_dir . 'image');
        $image->alt = 'placeholder';
        $image->save();

        return $image;
    }

    private function get_template_variants()
    {
        if (!file_exists($this->template)) {
            throw new \RuntimeException("Template image not found: $this->template");
        }

        $dir = dirname($this->template);

        $files = scandir($dir);

        if (! $files) {
            throw new \RuntimeException("Directory $dir is empty");
        }

        return $files;
    }
}
