<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use Factories\CardFactory;
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

        $res = $db->exec("SELECT count(*) FROM information_schema.views WHERE table_schema='public' AND table_name='flip_cards'");
        $this->assertEquals(1, $res[0]['count'], 'No view found');
    }
}
