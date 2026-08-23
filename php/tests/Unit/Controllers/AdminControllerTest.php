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
        $blacklisted = ['admin/login', 'admin/logout'];
        $whitelisted = ['admin'];

        $all_routes = get_flat_routes();

        $protected_routes = [];

        foreach ($all_routes as $route) {
            $path = $route['url'];

            $is_blacklisted = array_any($blacklisted, fn($blacklist) => str_contains($path, $blacklist));
            $is_whitelisted = array_all($whitelisted, fn($prefix) => str_contains($path, $prefix));

            if ($is_blacklisted || !$is_whitelisted) {
                continue;
            }

            $protected_routes[] = [$route['method'], $route['url']];
        }

        return $protected_routes;
    }
}
