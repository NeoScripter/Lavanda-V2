<?php

declare(strict_types=1);

namespace Http\Controllers\Api;

use Http\Controller;
use Http\Models\Iching;
use Support\AccessStatus;
use Support\Auth;
use Support\Session;

class IchingController extends Controller
{
    public function __invoke(\Base $hive)
    {
        $user = Auth::user();

        if (empty($user) || ! AccessStatus::can_play_game($user)) {
            send_json(['message' =>  "You don't have the access to this game"], 403);
        }

        AccessStatus::subtract_game($user);

        $locale = Session::get_locale();
        $bitmask  = $hive->GET['bitmask'];

        $bitmask = is_numeric($bitmask)
            ? (int) $bitmask
            : null;

        $bitmask = $bitmask > 64 ? null : $bitmask;

        $iching = new Iching();
        $iching->load(['bitmask = ? AND locale = ?', $bitmask, $locale]);

        if ($iching->dry()) {
            send_json(['message' =>  "Iching with this bitmask was not found"], 400);
        }

        $payload = [
            'number' => $iching->number,
            'description' => $iching->description,
        ];

        send_json($payload);
    }
}
