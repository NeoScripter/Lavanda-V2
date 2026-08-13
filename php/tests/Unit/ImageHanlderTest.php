<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use Support\ImageHandler;
use Tests\TestCase;

final class ImageHanlderTest extends TestCase
{

    #[Test]
    public function appends_slash_to_app_url_if_not_present(): void
    {
        $app_url = 'https://example.com';
        $relative_path = 'images/models/example';
        $source_path = APP_DIR . '/' . $relative_path;

        $this->hive->set('app_url', $app_url);

        $target_path = $app_url . '/' . $relative_path;

        $normalized_path = ImageHandler::normalize_path($source_path);

        $this->assertEquals($target_path, $normalized_path);
    }

    #[Test]
    public function doesnt_append_slash_to_app_url_if_when_present(): void
    {
        $app_url = 'https://example.com/';
        $relative_path = '/images/models/example';
        $source_path = APP_DIR . '/' . $relative_path;

        $this->hive->set('app_url', $app_url);

        $target_path = $app_url . '/' . $relative_path;

        $normalized_path = ImageHandler::normalize_path($source_path);

        $this->assertEquals($target_path, $normalized_path);
    }

    #[Test]
    public function removes_double_slashes_from_path(): void
    {
        $app_url = 'https://example.com/';
        $relative_path = 'images/models/example';
        $source_path = APP_DIR . '/' . $relative_path;

        $this->hive->set('app_url', $app_url);

        $target_path = $app_url . '/' . $relative_path;

        $normalized_path = ImageHandler::normalize_path($source_path);

        $this->assertEquals($target_path, $normalized_path);
    }
}
