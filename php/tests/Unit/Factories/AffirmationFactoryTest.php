<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use Factories\AffirmationFactory;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class AffirmationFactoryTest extends TestCase
{
    private ?AffirmationFactory $factory = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new AffirmationFactory();
    }

    #[Test]
    public function creates_affirmation_and_persists_to_database(): void
    {
        $affirmation = $this->factory->create();

        $this->assertNotEmpty($affirmation->quote);

        $rows = $this->hive->DB->exec('SELECT quote from affirmations where id = ?', [$affirmation->id]);

        $this->assertNotEmpty($rows);
        $this->assertEquals($affirmation->quote, $rows[0]['quote']);
    }
}
