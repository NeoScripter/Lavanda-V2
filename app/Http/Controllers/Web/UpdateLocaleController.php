<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Enums\Locale;
use Http\Controller;

class UpdateLocaleController extends Controller
{
    public function __invoke(\Base $hive)
    {
        $locale = Locale::normalize($hive->GET['locale'] ?? '');

        $hive->set('COOKIE.locale', $locale);
        $hive->reroute($hive->HEADERS['Referer'] ?? '/');
    }
}
