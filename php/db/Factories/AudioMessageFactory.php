<?php

declare(strict_types=1);

namespace Factories;

use Http\Models\AudioMessage;

class AudioMessageFactory extends Factory
{
    public function create(array $attrs, string $file)
    {
        if (! isset($attrs['description'])) {
            throw new \RuntimeException("Description is not provided");
        }
        if (! is_file($file)) {
            throw new \RuntimeException("File $file doesn't exist");
        }

        $new_dir = \UPLOAD_DIR . '/' . uniqid() . '/';

        if (!is_dir($new_dir)) {
            mkdir($new_dir, 0755, true);
        }

        $to = remove_extra_slashes($new_dir . '/' . extract_file_name($file));

        if (!copy(to: $to, from: $file)) {
            throw new \RuntimeException("Failed to copy $file to $to");
        }

        $audio = new AudioMessage();
        $audio->file = to_public_url($to);
        $audio->description = $attrs['description'];
        $audio->save();

        return $audio;
    }
}
