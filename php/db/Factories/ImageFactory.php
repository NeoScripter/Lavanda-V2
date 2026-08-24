<?php

declare(strict_types=1);

namespace Factories;

use Http\Models\Image;

class ImageFactory extends Factory
{
    public function __construct(public ?string $template = '', ?string $variant = 'front_image')
    {
        $this->template = APP_DIR . "/db/Fixtures/Image/{$variant}/placeholder.png";
    }

    public function create(string $dir, string $imageable_type, int $imageable_id, ?string $variant = 'image')
    {
        $files = $this->get_template_variants();

        $new_dir = \UPLOAD_DIR . "$dir/" . uniqid() . '/';

        if (!is_dir($new_dir)) {
            mkdir($new_dir, 0755, true);
        }

        $this->copy_variants_to_new_directory($new_dir, $files);

        $image = new Image();
        $image->src = to_public_url($new_dir . 'placeholder.png');
        $image->alt = 'placeholder';
        $image->variant = $variant;
        $image->imageable_id = $imageable_id;
        $image->imageable_type = $imageable_type;
        $image->save();

        return $image;
    }

    private function copy_variants_to_new_directory(string $new_dir, array $files)
    {
        foreach ($files as $file) {
            if (!copy($this->template, $new_dir . $file)) {
                throw new \RuntimeException("Failed to copy $file to $new_dir");
            }
        }
    }

    private function get_template_variants()
    {
        if (!file_exists($this->template)) {
            throw new \RuntimeException("Template image not found: $this->template");
        }

        $dir = dirname($this->template);

        $files = array_filter(scandir($dir), fn($file) => is_file($dir . '/' . $file));

        if (! $files) {
            throw new \RuntimeException("Directory $dir is empty");
        }

        return $files;
    }
}
