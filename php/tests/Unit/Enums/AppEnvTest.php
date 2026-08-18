<?php

declare(strict_types=1);

namespace Tests\Unit\Enums;

use Enums\AppEnv;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class AppEnvTest extends TestCase
{
    #[Test]
    public function correctly_defines_environment(): void
    {
        \Base::instance()->set('app_env', AppEnv::TESTING->value);

        $this->assertTrue(AppEnv::check(AppEnv::TESTING));
        $this->assertFalse(AppEnv::check(AppEnv::DEVELOPMENT));
        $this->assertFalse(AppEnv::check(AppEnv::PRODUCTION));
    }
}
