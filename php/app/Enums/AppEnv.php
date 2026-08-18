<?php

namespace Enums;

enum AppEnv: string
{
    case PRODUCTION = 'final';
    case DEVELOPMENT = 'development';
    case TESTING = 'test';

    public static function values()
    {
        return array_column(self::cases(), 'value');
    }

    public static function is(self $case): bool
    {
        $env = \Base::instance()->get('app_env');
        return self::from($env) === $case;
    }
}
