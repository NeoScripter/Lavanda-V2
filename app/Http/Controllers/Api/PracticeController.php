<?php

declare(strict_types=1);

namespace Http\Controllers\Api;

use Http\Controller;
use Http\Models\PracticeItemAsset;
use Support\AccessStatus;
use Support\Auth;
use Support\Session;

class PracticeController extends Controller
{
    public function __invoke()
    {
        // $user = Auth::user();
        //
        // if (empty($user) || (! AccessStatus::is_admin($user) && ! AccessStatus::has_active_subscription($user))) {
        //     send_json(['message' =>  "You don't have the access to these materials"], 403);
        // }

        $locale = Session::get_locale();

        $items = new PracticeItemAsset();
        $items = $items->find(
            ['locale=?', $locale],
        );

        if (! $items) {
            send_json(['message' =>  "Items not found"], 404);
        }

        $payload = [];

        foreach ($items as $item) {
            $payload[] = $item->to_item();
        }

        send_json($payload);
    }
}
