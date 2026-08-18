<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class AdminControllerTest extends TestCase
{

    #[Test]
    #[DataProvider('routes')]
    public function redirects_non_admins_from_admin_panel(string $method, string $uri): void
    {
        $response = $this->request(method: $method, uri: $uri);
        $this->assert_redirect(url: '/login', response: $response);
    }

    public static function routes(): array
    {
        $hive = \Base::instance();

        $routes = [];

        foreach ($hive->get('ROUTES') as $url => $methods) {

            if (str_contains($url, 'login') || ! str_contains($url, 'admin') || str_contains($url, 'logout')) {
                continue;
            }
            foreach ($methods as $route) {
                foreach ($route as $method => $_) {
                    $routes[] = [$method, $url];
                }
            }
        }

        return $routes;
    }
}
