<?php

namespace Enums;

enum Locale: string
{
    case ENGLISH = 'en';
    case RUSSIAN = 'ru';
    case SERBIAN = 'sr';
    case GERMAN = 'de';

    public static function values()
    {
        return array_column(self::cases(), 'value');
    }

    public static function normalize(string $input): string
    {
        return in_array($input, self::values(), true) ? $input : self::ENGLISH->value;
    }

    public static function labels(): array
    {
        $labels = [];

        foreach (self::cases() as $case) {
            $labels[$case->value] = $case->label();
        }

        return $labels;
    }

    public function label(): string
    {
        $hive = \Base::instance();

        return match ($this) {
            self::ENGLISH => $hive->get('admin.english'),
            self::RUSSIAN => $hive->get('admin.russian'),
            self::SERBIAN => $hive->get('admin.serbian'),
            self::GERMAN => $hive->get('admin.german'),
        };
    }
}
