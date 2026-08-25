<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use Factories\PracticeItemFactory;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class PracticeItemFactoryTest extends TestCase
{
    private ?PracticeItemFactory $factory = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new PracticeItemFactory();
    }

    #[Test]
    public function creates_item_and_persists_to_database(): void
    {
        $item = $this->factory->create();

        $this->assertNotEmpty($item->title);

        $rows = $this->hive->DB->exec('SELECT title from practice_items where id = ?', [$item->id]);

        $this->assertNotEmpty($rows);
        $this->assertEquals($item->title, $rows[0]['title']);
    }

    #[Test]
    public function deleting_item_also_deletes_its_image(): void
    {
        $item = $this->factory->create();
        $image = $item->image;
        $item_id = $item->id;

        $db = $this->hive->get('DB');

        $item->erase();

        $item_still_exists = $db->exec('SELECT 1 FROM practice_items WHERE id = ?', [$item_id]);
        $image_still_exists = $db->exec('SELECT 1 FROM images WHERE id = ?', [$image->id]);

        $this->assertEmpty($item_still_exists, 'PracticeItem should be deleted');
        $this->assertEmpty($image_still_exists, 'Image should also be deleted');
    }

    #[Test]
    public function serializes_a_faq_array(): void
    {
        $faq = [
            'question' => 'example question',
            'answer' => 'example answer',
        ];

        $faqs = [];
        for ($i = 0; $i < 4; $i++) {
            $faqs[] = $faq;
        }

        $item = $this->factory->create(attrs: ['faqs' => $faqs]);

        $this->assertIsArray($item->faqs);
    }

    // #[Test]
    // public function discards_data_when_invalid_json_supplied_for_faqs_field(): void
    // {
    //     $faq = [
    //         'invalid_question' => 'example question',
    //         'invalid_answer' => 'example answer',
    //     ];
    //
    //     $faqs = [];
    //     for ($i = 0; $i < 4; $i++) {
    //         $faqs[] = $faq;
    //     }
    //
    //     $item = $this->factory->create(attrs: ['faqs' => $faqs]);
    //
    //     $this->assertNull($item->faqs);
    // }
}
