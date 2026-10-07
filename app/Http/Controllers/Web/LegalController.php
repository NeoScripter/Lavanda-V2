<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Http\Controller;
use Http\Models\Legal;
use Support\Session;

class LegalController extends Controller
{
    public function show(\Base $hive)
    {
        $slug = $hive->PARAMS['slug'];

        $locale = Session::get_locale();
        $article = new Legal();
        $article->load(['slug=? AND locale=?', $slug, $locale]);
        $article->virtual('name', $article->slug);

        view('pages/web/article', compact('article'));
    }
}
