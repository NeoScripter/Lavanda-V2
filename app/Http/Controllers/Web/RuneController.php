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
        // $items = $items->select(
        //     'id, title, description, created_at',
        //     ['locale=?', $locale],
        //     ['order' => 'created_at DESC']
        // );
        $runes = $runes->find(
            ['locale=?', $locale],
            ['order' => 'created_at DESC']
        );

        shuffle($runes);

        view('pages/web/runes', compact('runes'));
    }
}
