<?php

namespace Enums;

enum DBView: string
{
    case FLIPCARD = 'flip_cards';
    case RUNE_ASSET = 'rune_assets';
    case PRACTICE_ITEM_ASSET = 'practice_item_asset';

    public static function values()
    {
        return array_column(self::cases(), 'value');
    }
}
