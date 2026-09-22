<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Enums\CardVariant;
use Http\Controller;
use Http\Models\FlipCard;

class PracticeItemController extends Controller
{
    public function index()
    {
        $locale = get_user_locale();

        $cards = new FlipCard();
        $cards = $cards->find(
            ['locale=? AND variant=?', $locale, CardVariant::BONUS->value],
            ['order' => 'created_at DESC']
        );

        view('pages/web/home', compact('cards'));
    }
}
