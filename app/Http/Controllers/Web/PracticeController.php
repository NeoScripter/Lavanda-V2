<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Http\Controller;
use Http\Models\PracticeItemAsset;
use Support\Session;

class PracticeController extends Controller
{
    public function index()
    {
        $locale = Session::get_locale();

        $items = new PracticeItemAsset();
        $items = $items->find(
            ['locale=?', $locale],
            ['order' => 'created_at DESC']
        );

        view('pages/web/practice', compact('items'));
    }
}
