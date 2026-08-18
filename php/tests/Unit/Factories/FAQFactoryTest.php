<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use Factories\FAQFactory;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class FAQFactoryTest extends TestCase
{
    private ?FAQFactory $factory = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new FAQFactory();
    }

    #[Test]
    public function creates_card_and_persists_to_database(): void
    {
        $faq = $this->factory->create();

        $this->assertNotEmpty($faq->answer);

        $rows = $this->hive->DB->exec('SELECT question from faqs where id = ?', [$faq->id]);

        $this->assertNotEmpty($rows);
        $this->assertEquals($faq->question, $rows[0]['question']);
    }
}
