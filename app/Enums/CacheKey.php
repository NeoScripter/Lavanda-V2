<?php

namespace Enums;

enum CacheKey: string
{
    case PASSWORD_RESET_HASH = 'password_reset_hash';

    public static function values()
    {
        return array_column(self::cases(), 'value');
    }
}
