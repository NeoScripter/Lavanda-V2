<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Http\Controller;
use Http\Models\Article;
use Http\Models\ArticlePreview;
use Support\AccessStatus;
use Support\Auth;
use Support\Session;

class ArticleController extends Controller
{
    public function index(\Base $hive)
    {
        $page = $hive->GET['page'] ?? 1;
        $page = is_numeric($page) ? (int) $page : 1;

        $locale = Session::get_locale();
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
        $user = Auth::user();

        if (! AccessStatus::is_admin($user) && ! AccessStatus::has_active_subscription($user)) {
            $hive->reroute('@home');
        }

        $id = $hive->PARAMS['id'];

        $locale = Session::get_locale();
        $article = new Article();
        $article->load(['id=? AND locale=?', $id, $locale]);

        view('pages/web/article', compact('article'));
    }
}
