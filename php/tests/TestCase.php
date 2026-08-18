<?php

namespace Tests;

use DB\SQL;
use GuzzleHttp\Client;
use Http\Controllers\CliController;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Psr\Http\Message\ResponseInterface;

abstract class TestCase extends BaseTestCase
{
    protected ?SQL $db = null;
    protected \Base $hive;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hive = \Base::instance();

        $this->run_migrations();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $hanlder = new CliController();
        $hanlder->drop($this->hive);
    }

    private function run_migrations(): void
    {
        $hanlder = new CliController();
        $hanlder->fresh($this->hive);
    }

    protected function request(string $method, string $uri): ResponseInterface
    {
        $client = new Client([
            'base_uri' => $this->hive->get('app_url'),
            'http_errors' => false,
            'allow_redirects' => false,
        ]);

        return $client->request($method, $uri);
    }

    protected function assert_redirect(string $url, ResponseInterface $response): void
    {
        $absolute_path = rtrim($this->hive->get('app_url'), '/') . $url;
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals($absolute_path, $response->getHeaderLine('Location'));
    }
}
