<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Http\Controller;
use Http\Models\RuneAsset;
use Support\Session;

class RuneController extends Controller
{
    public function index()
    {
        $locale = Session::get_locale();

        $runes = new RuneAsset();
        $runes = $runes->select(
            'id, locale, created_at, front_src, front_alt, back_src, back_alt',
            ['locale=?', $locale],
            ['order' => 'created_at DESC']
        );

        shuffle($runes);

        view('pages/web/runes', compact('runes'));
    }
}
