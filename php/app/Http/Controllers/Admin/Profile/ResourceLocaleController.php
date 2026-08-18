<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\Profile;

use Enums\Locale;
use Enums\SessionKey;
use Http\Controller;
use Support\Auth;

class ResourceLocaleController extends Controller
{
    public function beforeroute(\Base $hive)
    {
        if (! Auth::check()) {
            $hive->reroute('@login');
        }
    }

    public function update(\Base $hive)
    {
        check_csrf($hive->POST);

        $hive->set(
            'SESSION.'. SessionKey::RESOURCE_LOCALE->value,
            Locale::normalize($hive->POST[SessionKey::RESOURCE_LOCALE->value] ?? 'en')
        );

        $referrer = $hive->HEADERS['Referer'] ?? '/';
        $hive->reroute($referrer);
    }
}
