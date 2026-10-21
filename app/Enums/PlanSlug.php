<?php

namespace Enums;

enum PlanSlug: string
{
    case ONE_TIME = 'one_time';
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';
    case PERSONAL = 'personal';

    public static function values()
    {
        return array_column(self::cases(), 'value');
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
            self::ONE_TIME => $hive->get('web.здесь_и_сейчас'),
            self::MONTHLY => $hive->get('web.остаться_на_месяц'),
            self::YEARLY => $hive->get('web.быть_вместе_год'),
            self::PERSONAL => $hive->get('web.поговорить_лично_с_lavanda'),
        };
    }
}
