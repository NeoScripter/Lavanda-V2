<?php

declare(strict_types=1);

namespace Http\Controllers\Api;

use Enums\GameType;
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

        if (! AccessStatus::can_play_game($user, GameType::ICHING->value)) {
            send_json(['message' =>  "You don't have the access to this game"], 403);
        }

        AccessStatus::subtract_game($user, GameType::ICHING->value);

        $locale = Session::get_locale();
        $bitmask  = $hive->GET['bitmask'];

        $bitmask = is_numeric($bitmask)
            ? (int) $bitmask
            : null;

        $bitmask = $bitmask > 64 ? null : $bitmask;

        $iching = new Iching();
        $iching->load(['bitmask = ? AND locale = ?', $bitmask, $locale]);
        $markdown = \Markdown::instance();

        if ($iching->dry()) {
            send_json(['message' =>  "Iching with this bitmask was not found"], 400);
        }

        $payload = [
            'number' => $iching->number,
            'description' => $markdown->convert($iching->description),
        ];

        send_json($payload);
    }
}
