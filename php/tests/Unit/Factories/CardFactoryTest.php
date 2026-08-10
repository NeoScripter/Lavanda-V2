<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use Factories\CardFactory;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class CardFactoryTest extends TestCase
{
    private ?CardFactory $factory = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new CardFactory();
    }

    #[Test]
    public function creates_card_and_persists_to_database(): void
    {
        $card = $this->factory->create();

        $this->assertNotEmpty($card->name);

        $rows = $this->hive->DB->exec('SELECT name from cards where id = ?', [$card->id]);

        $this->assertNotEmpty($rows);
        $this->assertEquals($card->name, $rows[0]['name']);
    }

    #[Test]
    public function fetching_card_also_fetches_its_front_image(): void
    {
        $card = $this->factory->create();

        $rows = $this->hive->DB->exec('SELECT src FROM images WHERE imageable_id = ?', [$card->id]);

        $this->assertNotEmpty($rows, "The image hasn't been persisted in db");

        $image = $card->front_image;

        $this->assertTrue(! empty($image->src), "The card doesn't have a front image");
        $this->assertEquals($image->src, $rows[0]['src']);
    }

    #[Test]
    public function deleting_card_also_deletes_its_front_image(): void
    {
        $card = $this->factory->create();
        $image = $card->front_image;

        $db = $this->hive->get('DB');

        $card->erase();

        $card_still_exists = $db->exec('SELECT 1 FROM cards WHERE id = ?', [$card->id]);
        $image_still_exists = $db->exec('SELECT 1 FROM images WHERE id = ?', [$image->id]);

        $this->assertEmpty($card_still_exists, 'Card should be deleted');
        $this->assertEmpty($image_still_exists, 'Image should also be deleted');
    }
}
