<?php

namespace Enums;

enum ClonableType: string
{
    case TAROT = 'tarot';
    case METAPHORIC = 'metaphoric';
    case LENORMAND = 'lenormand';
    case MIND_GAMES = 'mind_games';
    case MINORI = 'minori';
    case RUNE = 'rune';
    case STONE = 'stone';
    case BONUS = 'bonus';
    case FAQ = 'faq';
    case ICHING = 'iching';
    case AFFIRMATION = 'affirmation';
    case ARTICLE = 'article';
    case AUDIOS = 'audios';
    case PRACTICE_ITEM = 'practice_item';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function normalize(string $input): string
    {
        return in_array($input, self::values(), true) ? $input : self::TAROT->value;
    }
}
