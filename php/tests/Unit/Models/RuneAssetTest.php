<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use Factories\RuneFactory;
use Http\Models\RuneAsset;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class RuneAssetTest extends TestCase
{
    private ?RuneFactory $factory = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new RuneFactory();
    }

    #[Test]
    public function deleting_rune_also_deletes_its_images(): void
    {
        $rune = $this->factory->create();
        $front_image_id = $rune->front_image->id;
        $back_image_id = $rune->back_image->id;

        $db = $this->hive->get('DB');

        $rune->erase();

        $rune_still_exists = $db->exec('SELECT 1 FROM runes WHERE id = ?', [$rune->id]);
        $front_image_still_exists = $db->exec('SELECT 1 FROM images WHERE id = ?', [$front_image_id]);
        $back_image_still_exists = $db->exec('SELECT 1 FROM images WHERE id = ?', [$back_image_id]);

        $this->assertEmpty($rune_still_exists, 'Rune should be deleted');
        $this->assertEmpty($front_image_still_exists, 'Front image should also be deleted');
        $this->assertEmpty($back_image_still_exists, 'Back image should also be deleted');
    }

    #[Test]
    public function fetches_complete_rune_asset_data(): void
    {
        $rune = $this->factory->create();

        $this->assertNotNull($rune->id);

        $rune_asset = new RuneAsset();
        $rune_asset->load(['id=?', $rune->id]);
        $rune_asset = $rune_asset->to_resource();

        $this->assertNotNull($rune_asset['front_image']['src'], 'Front image is not present');
        $this->assertNotNull($rune_asset['back_image']['src'], 'Back image is not present');
    }
}

