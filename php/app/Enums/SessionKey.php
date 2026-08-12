<?php

namespace Enums;

enum SessionKey: string
{
    case CARD_VARIANT = 'card_variant';
    case RESOURCE_LOCALE = 'resource_locale';

    public static function values()
    {
        return array_column(self::cases(), 'value');
    }
}
