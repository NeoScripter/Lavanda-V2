<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use Enums\CardVariant;
use Enums\DBView;
use Factories\CardFactory;
use Http\Models\FlipCard;
use Http\Models\Image;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class FlipCardTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    #[Test]
    public function creates_flip_cards_table_view_during_migrations(): void
    {
        $db = $this->hive->get('DB');
        $view = DBView::FLIPCARD->value;

        $res = $db->exec("SELECT count(*) FROM information_schema.views WHERE table_schema='public' AND table_name='{$view}'");
        $this->assertEquals(1, $res[0]['count'], 'No view found');
    }

    #[Test]
    public function includes_both_image_variants_when_retrieved_as_resource(): void
    {
        $factory = new CardFactory();
        $card = $factory->create(with_back: true);

        $flip_card = (new FlipCard())->load(['id=?', $card->id]);
        $flip_card = $flip_card->to_resource();

        $this->assertNotEmpty($flip_card['front_image']['src'], 'The card does not have a front image');
        $this->assertNotEmpty($flip_card['back_image']['src'], 'The card does not have a back image');
    }

    #[Test]
    public function generates_card_backs_on_migration(): void
    {
        $db = $this->hive->get('DB');

        $variant_num = count(CardVariant::values());

        $res = $db->exec("SELECT count(*) FROM images");
        $this->assertEquals($variant_num, $res[0]['count'], 'No view found');
    }

    #[Test]
    public function deletes_only_front_image_when_deleted(): void
    {
        $factory = new CardFactory();
        $card = $factory->create(with_back: true);

        $flip_card = (new FlipCard())->load(['id=?', $card->id]);
        $flip_card = $flip_card->to_resource();

        $card->erase();
        $front_image = new Image();
        $front_image->load(['id=?', $flip_card['front_image']['id']]);
        $back_image = new Image();
        $back_image->load(['id=?', $flip_card['back_image']['id']]);

        $this->assertTrue($front_image->dry());
        $this->assertNotTrue($back_image->dry());
    }
}
