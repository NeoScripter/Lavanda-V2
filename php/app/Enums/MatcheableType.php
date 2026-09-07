<?php

namespace Enums;

enum MatcheableType: string
{
    case TAROT = 'tarot';
    case METAPHORIC = 'metaphoric';
    case LENORMAND = 'lenormand';
    case MIND_GAMES = 'mind_games';
    case RUNE = 'rune';
    case STONE = 'stone';
    case BONUS = 'bonus';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
