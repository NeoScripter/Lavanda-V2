<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use Factories\StoneFactory;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class StoneFactoryTest extends TestCase
{
    private StoneFactory $factory;
    private string $preview_src;
    private string $image_src;
    private array $attrs;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new StoneFactory();
        $this->preview_src = APP_DIR . '/db/Fixtures/Image/front_image/';
        $this->image_src = APP_DIR . '/db/Fixtures/Image/front_image/';
        $this->attrs = [
            'name' => 'test_name',
            'html' => 'test_html',
        ];
    }

    #[Test]
    public function creates_stone_and_persists_to_database(): void
    {
        $stone = $this->factory->create(
            attrs: $this->attrs,
            preview_src: $this->preview_src,
            image_src: $this->image_src
        );

        $this->assertNotEmpty($stone->name);

        $rows = $this->hive->DB->exec('SELECT name from stones where id = ?', [$stone->id]);

        $this->assertNotEmpty($rows);
        $this->assertEquals($stone->name, $rows[0]['name']);
    }
}
