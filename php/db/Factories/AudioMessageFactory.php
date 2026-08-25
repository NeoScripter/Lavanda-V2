<?php

declare(strict_types=1);

namespace Factories;

use Http\Models\AudioMessage;

class AudioMessageFactory extends Factory
{
    public function create()
    {
        $template = APP_DIR . "/db/Fixtures/Audio/audio-1.mp3";
        $dir = dirname($template);

        $files = array_filter(
            scandir($dir),
            fn($file) => is_file($dir . '/' . $file)
        );

        if (! $files) {
            throw new \RuntimeException("Directory $dir is empty");
        }


        $files = array_values($files);
        $new_dir = \UPLOAD_DIR . '/' . uniqid() . '/';

        if (!is_dir($new_dir)) {
            mkdir($new_dir, 0755, true);
        }

        $random_idx = rand(0, count($files) - 1);
        $from = remove_extra_slashes($dir . '/' . $files[$random_idx]);
        $to = remove_extra_slashes($new_dir . '/' . $files[$random_idx]);

        if (!copy(to: $to, from: $from)) {
            throw new \RuntimeException("Failed to copy $from to $to");
        }

        $audio = new AudioMessage();
        $audio->file = to_public_url(path: $to, strip_extension: false);
        $audio->description = 'placeholder';
        $audio->save();

        return $audio;
    }
}
