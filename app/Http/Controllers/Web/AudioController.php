<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Http\Controller;
use Http\Models\AudioMessage;
use Support\Session;

class AudioController extends Controller
{
    public function index()
    {
        $locale = Session::get_locale();

        $audios = new AudioMessage();
        $audios = $audios->find(
            ['locale=?', $locale],
            ['order' => 'created_at DESC']
        );

        view('pages/web/audios', compact('audios'));
    }
}
