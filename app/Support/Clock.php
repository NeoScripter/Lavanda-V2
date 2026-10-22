<?php

declare(strict_types=1);

namespace Support;

use DateInterval;
use DateTime;

final class Clock
{
    public static function turn_back(string $interval): void
    {
        \Base::instance()->set('CURRENT_DATE', new DateTime()->sub(new DateInterval($interval))->format('Y-m-d'));
    }

    public static function reset(): void
    {
        \Base::instance()->set('CURRENT_DATE', 'now');
    }

    public static function turn_forward(string $interval): void
    {
        \Base::instance()->set('CURRENT_DATE', new DateTime()->add(new DateInterval($interval))->format('Y-m-d'));
    }
}
