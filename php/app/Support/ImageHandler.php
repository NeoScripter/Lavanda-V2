<?php

declare(strict_types=1);

namespace Support;

use Exception;
use RuntimeException;
use Imagick;

class ImageHandler
{
    private $locked = false;

    public static function make(): static
    {
        return new self();
    }

    public function process(array $files, array $sizes)
    {
        $result = [];

        foreach ($files as $file) {
            $src = $this->process_one($file['src'], $sizes);

            $result[] = ['src' => $src, 'alt' => $file['alt']];
        }

        return $result;
    }

    private function process_one(string $src, array $sizes)
    {
        if ($this->locked) {
            throw new Exception('The image handler is locked, finish processing the current batch first');
        }

        $this->locked = true;

        $dest = $this->compress($src);

        $this->resize_all($sizes, $dest);

        $this->locked = false;

        return to_public_url($dest);
    }

    public function resize_all(array $sizes, string $dest)
    {
        $suffixes = $this->get_size_map($sizes);

        foreach ($suffixes as $suffix => $size) {
            $path = $this->resize_to($size, $dest, $suffix);
            $this->to_webp($path);
            $this->to_avif($path, true);
        }
    }

    public function compress(string $path)
    {
        try {
            $png_path = preg_replace('/\.[^.]+$/', '.png', $path);

            $img = new Imagick($path);
            $img->stripImage();
            $img->setImageFormat('png');
            $img->writeImage($png_path);
            $img->clear();

            if ($png_path !== $path) {
                unlink($path);
            }

            $cmd = sprintf('oxipng -o 3 --strip safe %s 2>&1', escapeshellarg($png_path));

            exec($cmd, output: $output, result_code: $code);

            if ($code !== 0) {
                throw new RuntimeException('PNG compression failed: ' . implode("\n", $output));
            }

            return $png_path;
        } catch (Exception $e) {
            ErrorHandler::handle($e);
        }
    }

    public function to_webp(string $path, bool $cleanup = false)
    {
        $this->convert_to('webp', $path, 75, $cleanup);
    }

    public function to_avif(string $path, bool $cleanup = false)
    {
        $this->convert_to('avif', $path, 50, $cleanup);
    }

    public function resize_to(int $width, string $path, string $suffix)
    {
        try {
            $new_path = substr_replace($path, $suffix . '.', strrpos($path, '.'), 1);
            $img = new Imagick($path);

            $img->resizeImage($width, 0, Imagick::FILTER_LANCZOS, 1);

            $img->writeImage($new_path);
            $img->clear();

            return $new_path;
        } catch (Exception $e) {
            ErrorHandler::handle($e);
        }
    }

    private function convert_to(string $format, string $path, int $quality = 75, bool $cleanup = false)
    {
        if (! in_array($format, ['webp', 'avif', 'png', 'jpg', 'jpeg'])) {
            throw new RuntimeException('Invalid image format in for image conversion: ' . $format);
        }

        try {
            $new_path = preg_replace('/\.[^.]+$/', ".{$format}", $path);

            $img = new Imagick($path);
            $img->setImageFormat($format);
            $img->setImageCompressionQuality($quality);
            $img->writeImage($new_path);
            $img->clear();

            if ($cleanup === true && $new_path !== $path) {
                unlink($path);
            }

            return $new_path;
        } catch (Exception $e) {
            ErrorHandler::handle($e);
        }
    }

    // format: ['mb' => 50, 'tb' => 100, 'dk' => 200],
    // output: ['-mb' => 150, '-mb2x' => 100, '-mb3x' => 50, '-tb' => 300, '-tb2x' => 200, '-tb3x' => 100, '-dk' => 600, '-dk2x' => 400, '-dk3x' => 200, '-mb-tiny' => 30]
    public static function get_size_map(array $base_widths)
    {
        $suffixes = [];

        foreach ($base_widths as $size => $base_w) {
            $entries = explode(', ', build_src_set('', $size, ''));

            foreach ($entries as $entry) {
                [$suffix, $density] = explode('. ', $entry);

                $suffixes[$suffix] = match (true) {
                    str_contains($density, '3') => $base_w * 3,
                    str_contains($density, '2') => $base_w * 2,
                    default                     => $base_w,
                };
            }
        }

        $suffixes['-mb-tiny'] = 30;

        return $suffixes;
    }
}
