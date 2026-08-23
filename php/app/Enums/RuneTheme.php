<?php

namespace Enums;

enum RuneTheme: string
{
    case GENERAL = 'general';
    case LOVE = 'love_and_relationship';
    case CAREER = 'career';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        $hive = \Base::instance();

        return match ($this) {
            self::CAREER => $hive->get('admin.career'),
            self::LOVE => $hive->get('admin.love_and_relationship'),
            self::GENERAL => $hive->get('admin.general'),
        };
    }
}
