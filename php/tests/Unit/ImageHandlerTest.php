<?php

declare(strict_types=1);

namespace Tests\Unit;

use Factories\CardFactory;
use Factories\ImageFactory;
use Http\Controllers\Admin\CardController;
use Jobs\ProcessImageJob;
use PHPUnit\Framework\Attributes\Test;
use Support\ImageHandler;
use Tests\TestCase;

final class ImageHandlerTest extends TestCase
{

    #[Test]
    public function correctly_generates_sizemap(): void
    {
        $source = ['mb' => 50, 'tb' => 100, 'dk' => 200];
        $target = ['-mb' => 50, '-mb2x' => 100, '-mb3x' => 150, '-tb' => 100, '-tb2x' => 200, '-tb3x' => 300, '-dk' => 200, '-dk2x' => 400, '-dk3x' => 600, '-mb-tiny' => 30];

        $result = ImageHandler::get_size_map($source);

        $this->assertEquals(expected: $target, actual: $result);
    }


    #[Test]
    public function removes_stale_morph_image_on_update(): void
    {
        $path = (new ImageFactory(variant: 'front'))->template;
        $subdir = UPLOAD_DIR . 'image_job_queue_test/';
        $new_path = $subdir . 'copy.png';

        if (!is_dir($subdir)) {
            mkdir($subdir, 0777, true);
        }
        copy($path, $new_path);

        $files = [['src' => $new_path, 'alt' => '']];

        $sizes = ['mb' => 2];
        $card = (new CardFactory())->create();

        $payload = [
            'imageable_id' => $card->id,
            'imageable_type' => $card->variant,
            'variant' => 'front',
            'sizes' => $sizes,
            'files' => $files,
        ];

        (new ProcessImageJob)->handle($payload);

        $db = $this->hive->get("DB");
        $res = $db->exec("SELECT count(*) FROM images WHERE imageable_id = ? AND imageable_type = ? AND variant = ?", [$card->id, $card->variant, 'front']);
        $this->assertEquals(1, $res[0]['count'], 'The stale image was not erased');
    }

    #[Test]
    public function job_processes_and_optimizes_image(): void
    {
        $path = (new ImageFactory(variant: 'front'))->template;
        $subdir = UPLOAD_DIR . 'image_job_queue_test/';
        $new_path = $subdir . 'copy.png';

        if (!is_dir($subdir)) {
            mkdir($subdir, 0777, true);
        }
        copy($path, $new_path);

        $files = [['src' => $new_path, 'alt' => '']];

        $sizes = ['mb' => 2, 'tb' => 4, 'dk' => 6];
        $card = (new CardFactory())->create();
        $card->front_image->erase();
        $id = $card->id;

        $payload = [
            'imageable_id' => $card->id,
            'imageable_type' => $card->variant,
            'variant' => 'front',
            'sizes' => $sizes,
            'files' => $files,
        ];

        (new ProcessImageJob)->handle($payload);

        $target_sizes = ['-mb.' => 2, '-mb2x.' => 4, '-mb3x.' => 6, '-tb.' => 4, '-tb2x.' => 8, '-tb3x.' => 12, '-dk.' => 6, '-dk2x.' => 12, '-dk3x.' => 18, '-mb-tiny.' => 30];

        $dir = get_parent_dir($new_path);
        $files = read_dir_files($dir);
        $target_count = (count($target_sizes) - 1) * 2 + 3;

        $this->assertIsArray($files);
        $this->assertEquals(expected: $target_count, actual: count($files));

        foreach ($target_sizes as $ext => $expected_width) {
            $matched_file = array_find(
                $files,
                fn($file) => str_contains($file, $ext)
            );

            $this->assertNotNull($matched_file);
            [$width,] = getimagesize($subdir . $matched_file);
            $this->assertEquals(expected: $expected_width, actual: $width);
        }

        $card->reset();
        $card->load(['id=?', $id]);
        $updated_image = $card->front_image;

        $this->assertNotNull(actual: $updated_image['src']);
    }
}
