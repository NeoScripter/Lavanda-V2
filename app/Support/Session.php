<?php

declare(strict_types=1);

namespace Support;

use Enums\Locale;

final class Session extends \Prefab
{
    public static function get_locale(): string
    {
        $raw = \Base::instance()->get('LANGUAGE');
        $default = Locale::RUSSIAN->value;

        if (empty($raw)) {
            return $default;
        }

        $primary = str_contains($raw, ',')
            ? explode(',', $raw)[0]
            : $raw;

        if (! in_array($primary, Locale::values(), true)) {
            return $default;
        }

        return $primary;
    }
}
