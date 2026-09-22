<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Http\Controller;
use Http\Models\Article;
use Http\Models\ArticlePreview;

class ArticleController extends Controller
{
    public function index(\Base $hive)
    {
        $page = $hive->GET['page'] ?? 1;
        $page = is_numeric($page) ? (int) $page : 1;

        $locale = get_user_locale();
        $articles = new ArticlePreview();
        $articles = $articles->paginate(
            $page - 1,
            12,
            ['locale=?', $locale],
            ['order' => 'created_at DESC']
        );

        view('pages/web/articles', compact('articles'));
    }

    public function show(\Base $hive)
    {
        $id = $hive->PARAMS['id'];

        $locale = get_user_locale();
        $article = new Article();
        $article->load(['id=? AND locale=?', $id, $locale]);

        view('pages/web/article', compact('article'));
    }
}
