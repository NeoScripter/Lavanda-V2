<?php

declare(strict_types=1);

namespace Http\Controllers\Api;

use Http\Controller;
use Http\Models\PracticeItemAsset;

class PracticeController extends Controller
{
    public function __invoke(\Base $hive)
    {
        $locale = get_user_locale();

        $item = new PracticeItemAsset();
        $item = $item->load(
            ['locale=? AND id=?', $locale, $hive->get('PARAMS.id')],
        );

        if (! $item) {
            send_json(['message' =>  "Item not found"], 404);
            $hive->error(404, "Item not found");
        }

        send_json($item->to_item());
    }
}
