<?php

namespace Enums;

enum RuneTheme: string
{
    case GENERAL = 'general';
    case LOVE = 'Love';
    case CAREER = 'career';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
