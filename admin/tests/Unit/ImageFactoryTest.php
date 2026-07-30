<?php

declare(strict_types=1);

namespace Tests\Unit;

use Factories\ImageFactory;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ImageFactoryTest extends TestCase
{
    private ?ImageFactory $factory = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new ImageFactory();
    }

    #[Test]
    public function returns_all_expected_template_variants(): void
    {
        $files = (fn() => $this->get_template_variants())->call($this->factory);

        $this->assertNotEmpty($files);

        $extensions = ['dk-tiny.webp', 'dk.avif', 'dk.webp', 'dk2x.avif', 'dk2x.webp', 'dk3x.avif', 'dk3x.webp', 'mb-tiny.webp', 'mb.avif', 'mb.webp', 'mb2x.avif', 'mb2x.webp', 'mb3x.avif', 'mb3x.webp', 'tb-tiny.webp', 'tb.avif', 'tb.webp', 'tb2x.avif', 'tb2x.webp', 'tb3x.avif', 'tb3x.webp', 'avif', 'png', 'webp']; // pint ignore/line

        foreach ($extensions as $ext) {
            $this->assertTrue(!!array_find($files, fn($file) => str_contains($file, $ext)));
        }
    }

    #[Test]
    public function test_creates_image_and_persists_to_database(): void
    {
        $image = $this->factory->create(dir: 'test', imageable_id: 1, imageable_type: 'test');

        $this->assertNotEmpty($image->src);

        $rows = $this->hive->DB->exec('SELECT src from images where id = ?', [$image->id]);

        $this->assertNotEmpty($rows);
        $this->assertEquals($image->src, $rows[0]['src']);
    }
}
