<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use Enums\ImageableType;
use Factories\ImageFactory;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ImageFactoryTest extends TestCase
{
    private ImageFactory $factory;
    private string $src_dir;
    private array $attrs;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new ImageFactory();
        $this->src_dir = APP_DIR . '/db/Fixtures/Image/front_image/';
        $this->attrs = [
            'imageable_type' => ImageableType::ARTICLE->value,
            'imageable_id' => 1,
            'variant' => 'image',
        ];
    }

    #[Test]
    public function returns_all_expected_template_variants(): void
    {
        $image = $this->factory->create(attrs: $this->attrs, src_dir: $this->src_dir);
        $this->assertNotEmpty($image->src);

        $files = read_dir_files(
            get_parent_dir(
                to_absolute_path($image->src)
            )
        );

        $this->assertNotEmpty($files);

        $extensions = ['dk-tiny.webp', 'dk.avif', 'dk.webp', 'dk2x.avif', 'dk2x.webp', 'dk3x.avif', 'dk3x.webp', 'mb-tiny.webp', 'mb.avif', 'mb.webp', 'mb2x.avif', 'mb2x.webp', 'mb3x.avif', 'mb3x.webp', 'tb-tiny.webp', 'tb.avif', 'tb.webp', 'tb2x.avif', 'tb2x.webp', 'tb3x.avif', 'tb3x.webp', 'avif', 'png', 'webp']; // pint ignore/line

        foreach ($extensions as $ext) {
            $this->assertTrue(!!array_find($files, fn($file) => str_contains($file, $ext)));
        }
    }

    #[Test]
    public function creates_image_and_persists_to_database(): void
    {
        $image = $this->factory->create(attrs: $this->attrs, src_dir: $this->src_dir);

        $this->assertNotEmpty($image->src);

        $rows = $this->hive->DB->exec('SELECT src from images where id = ?', [$image->id]);

        $this->assertNotEmpty($rows);
        $this->assertEquals($image->src, $rows[0]['src']);
    }

    #[Test]
    public function deleting_image_also_deletes_its_files(): void
    {
        $image = $this->factory->create(attrs: $this->attrs, src_dir: $this->src_dir);

        $this->assertNotEmpty($image->src);

        $dir = get_parent_dir(
            to_absolute_path($image->src)
        );

        $image->erase();

        $this->assertDirectoryDoesNotExist($dir);
    }
}
