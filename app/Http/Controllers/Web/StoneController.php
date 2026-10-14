<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Http\Controller;
use Http\Models\StoneAsset;
use Support\Session;

class StoneController extends Controller
{
    public function index()
    {
        $locale = Session::get_locale();

        $stones = new StoneAsset();
        $stones = $stones->select(
            'id, locale, created_at, preview_src, preview_alt',
            ['locale=?', $locale],
            ['order' => 'created_at DESC']
        );

        shuffle($stones);

        view('pages/web/stones', compact('stones'));
    }
}
