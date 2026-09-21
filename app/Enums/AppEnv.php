<?php

namespace Enums;

enum AppEnv: string
{
    case PRODUCTION = 'production';
    case DEVELOPMENT = 'development';
    case TESTING = 'test';

    public static function values()
    {
        return array_column(self::cases(), 'value');
    }

    public static function is(self $case): bool
    {
        $env = getenv('APP_ENV');
        return self::from($env) === $case;
    }
}
