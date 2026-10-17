<?php

declare(strict_types=1);

namespace Http\Controllers\Api;

use Http\Controller;
use Http\Models\Iching;
use Support\Session;

class DiceController extends Controller
{
    public function __invoke(\Base $hive)
    {
        $locale = Session::get_locale();
        $theme  = $hive->GET['theme'];
        $winner_id  = $hive->GET['winner_id'];

        // $iching = new Iching();
        // $iching->load(['bitmask = ? AND locale = ?', $bitmask, $locale]);
        //
        // if ($iching->dry()) {
        //     send_json(['message' =>  "Iching with this bitmask was not found"], 400);
        // }
        //
        $payload = [
            'html' => '<h3>Hello world</h3><p>Helo Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio, et id! Obcaecati necessitatibus eaque incidunt, nesciunt nemo aut ipsum quasi.</p>',
        ];

        send_json($payload);
    }
}
