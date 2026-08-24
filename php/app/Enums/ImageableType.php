<?php

namespace Enums;

enum ImageableType: string
{
    case TAROT = 'tarot';
    case METAPHORIC = 'metaphoric';
    case LENORMAND = 'lenormand';
    case MIND_GAMES = 'mind_games';
    case RUNE = 'rune';
    case BONUS = 'bonus';
    case PRACTICE = 'practice';
    case ARTICLE = 'article';
    case PRACTICE_ITEM = 'practice_item';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
