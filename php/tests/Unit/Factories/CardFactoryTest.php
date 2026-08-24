<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use Enums\CardVariant;
use Factories\CardFactory;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use ValueError;

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
    public function deleting_card_also_deletes_its_front_image(): void
    {
        $card = $this->factory->create();
        $image_id = $card->front_image->id;

        $db = $this->hive->get('DB');

        $card->erase();

        $card_still_exists = $db->exec('SELECT 1 FROM cards WHERE id = ?', [$card->id]);
        $image_still_exists = $db->exec('SELECT 1 FROM images WHERE id = ?', [$image_id]);

        $this->assertEmpty($card_still_exists, 'Card should be deleted');
        $this->assertEmpty($image_still_exists, 'Image should also be deleted');
    }

    #[Test]
    public function attributes_have_priority_over_default_values(): void
    {
        $attrs = ['name' => 'Test 1', 'variant' => CardVariant::TAROT->value];
        $card = $this->factory->create($attrs);

        $this->assertEquals($attrs['name'], $card->name);
        $this->assertEquals($attrs['variant'], $card->variant);
    }

    #[Test]
    public function throws_when_imageable_type_is_invalid(): void
    {
        $this->expectException(ValueError::class);
        $this->factory->create(attrs: ['variant' => 'invalid']);
    }
}
