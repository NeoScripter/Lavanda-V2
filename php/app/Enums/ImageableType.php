<?php

namespace Enums;

enum ImageableType: string
{
    case TAROT = 'tarot';
    case METAPHORIC = 'metaphoric';
    case LENORMAND = 'lenormand';
    case BONUS = 'bonus';
    case PRACTICE = 'practice';
    case ARTICLE = 'article';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
