<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Enums\CardVariant;
use Http\Controller;
use Http\Models\FlipCard;
use Support\Session;

class MetaphoricController extends Controller
{
    public function index()
    {
        $locale = Session::get_locale();

        $cards = new FlipCard();
        $cards = $cards->find(
            ['locale=? AND variant=?', $locale, CardVariant::METAPHORIC->value],
            ['order' => 'created_at DESC']
        );

        shuffle($cards);

        view('pages/web/metaphoric', compact('cards'));
    }
}
