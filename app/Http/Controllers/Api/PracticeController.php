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

        $items = new PracticeItemAsset();
        $items = $items->find(
            ['locale=?', $locale],
        );

        if (! $items) {
            send_json(['message' =>  "Items not found"], 404);
            $hive->error(404, "Items not found");
        }

        $payload = [];

        foreach ($items as $item) {
            $payload[] = $item->to_item();
        }

        send_json($payload);
    }
}
