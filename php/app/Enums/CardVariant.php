<?php

namespace Enums;

enum CardVariant: string
{
    case TAROT = 'tarot';
    case METAPHORIC = 'metaphoric';
    case LENORMAND = 'lenormand';
    case MIND_GAME = 'mind_game';
    case BONUS = 'bonus';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function normalize(string $input): string
    {
        return in_array($input, self::values(), true) ? $input : self::TAROT->value;
    }
}
