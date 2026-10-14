<?php

declare(strict_types=1);

namespace Http\Controllers\Api;

use Http\Controller;
use Http\Models\Iching;
use Support\Session;

class IchingController extends Controller
{
    public function __invoke(\Base $hive)
    {
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
