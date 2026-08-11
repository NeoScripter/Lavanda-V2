<?php

namespace Enums;

enum Locale: string
{
    case ENGLISH = 'en';
    case RUSSIAN = 'ru';
    case SERBIAN = 'sr';
    case GERMAN = 'de';

    public static function values()
    {
        return array_column(self::cases(), 'value');
    }

    public static function normalize(string $input): string
    {
        return in_array($input, self::values(), true) ? $input : self::ENGLISH->value;
    }
}
