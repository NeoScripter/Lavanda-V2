<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Http\Controller;
use Http\Models\PracticeItemAsset;

class PracticeController extends Controller
{
    public function index()
    {
        $locale = get_user_locale();

        $items = new PracticeItemAsset();
        $items = $items->find(
            ['locale=?', $locale],
            ['order' => 'created_at DESC']
        );

        view('pages/web/practice', compact('items'));
    }
}
