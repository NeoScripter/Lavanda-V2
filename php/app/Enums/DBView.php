<?php

namespace Enums;

enum DBView: string
{
    case FLIPCARD = 'flip_cards';

    public static function values()
    {
        return array_column(self::cases(), 'value');
    }
}
