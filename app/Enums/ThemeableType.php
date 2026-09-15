<?php

namespace Enums;

enum ThemeableType: string
{
    case TAROT = 'tarot';
    case METAPHORIC = 'metaphoric';
    case LENORMAND = 'lenormand';
    case MIND_GAMES = 'mind_games';
    case RUNE = 'rune';
    case BONUS = 'bonus';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
