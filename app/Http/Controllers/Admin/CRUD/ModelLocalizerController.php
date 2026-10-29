<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Enums\ClonableType;
use Enums\Locale;
use Enums\SessionKey;
use Http\Controller;
use Support\ModelLocalizer;
use Traits\RequiresAdminRights;

class ModelLocalizerController extends Controller
{
    use RequiresAdminRights;

    public function __invoke(\Base $hive)
    {
        $locale = $hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value);

        $referrer = $hive->HEADERS['Referer'] ?? '/admin';

        if ($locale === Locale::RUSSIAN->value) {
            notify($hive->get('Cannot clone Russian resource'));
            $hive->reroute($referrer);
            exit;
        }

        $category = ClonableType::from($hive->POST['category']);

        $cloner = new ModelLocalizer(category: $category, locale: Locale::from($locale));

        notify($cloner->clone_all());

        $hive->reroute($referrer);
    }
}
