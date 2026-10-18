<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Enums\ThemeableType;
use Http\Controller;
use Support\Session;

class DiceController extends Controller
{
    public function index()
    {
        $locale = Session::get_locale();

        // $themes = get_unique_themes_by_type();
        $themes = [];
        $db = \Base::instance()->get('DB');

        $themes = $db->exec(
            "SELECT t1.name
            FROM themes t1
            WHERE t1.themeable_type = ?
            GROUP BY t1.name
            ORDER BY t1.name",
            [ThemeableType::DICE->value]
        );

        dd($themes);

        view('pages/web/dices', compact('themes'));
    }
}
