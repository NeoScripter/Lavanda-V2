<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use Factories\AudioMessageFactory;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class AudioMessageFactoryTest extends TestCase
{
    private ?AudioMessageFactory $factory = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new AudioMessageFactory();
    }

    #[Test]
    public function creates_audio_and_persists_to_database(): void
    {
        $audio = $this->factory->create();

        $this->assertNotEmpty($audio->file);

        $rows = $this->hive->DB->exec('SELECT file from audio_messages where id = ?', [$audio->id]);

        $this->assertNotEmpty($rows);
        $this->assertEquals($audio->file, $rows[0]['file']);
    }

    #[Test]
    public function deleting_audio_also_deletes_its_file(): void
    {
        $audio = $this->factory->create();
        $file = $audio->file;
        $audio_id = $audio->id;

        $db = $this->hive->get('DB');

        $audio->erase();

        $audio_still_exists = $db->exec('SELECT 1 FROM audio_messages WHERE id = ?', [$audio_id]);

        $this->assertEmpty($audio_still_exists, 'Audio should be deleted');
        $this->assertFileDoesNotExist($file, 'Audio file should also be deleted');
    }
}
