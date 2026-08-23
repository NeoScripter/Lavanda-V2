<?php

namespace Enums;

enum DBView: string
{
    case FLIPCARD = 'flip_cards';
    case RUNE_ASSET = 'rune_assets';

    public static function values()
    {
        return array_column(self::cases(), 'value');
    }
}
