<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Enums\CardVariant;
use Http\Controller;
use Http\Models\FlipCard;

class ArticleController extends Controller
{
    public function index()
    {
        $locale = get_user_locale();

        view('pages/web/articles');
    }
}
