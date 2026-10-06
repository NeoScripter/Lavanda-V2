<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Enums\CardVariant;
use Http\Controller;
use Http\Models\FlipCard;
use Support\Session;

class TarotController extends Controller
{
    public function index()
    {
        $locale = Session::get_locale();

        $cards = new FlipCard();
        $cards = $cards->find(
            ['locale=? AND variant=?', $locale, CardVariant::TAROT->value],
            ['order' => 'created_at DESC']
        );

        shuffle($cards);

        view('pages/web/tarot', compact('cards'));
    }
}
