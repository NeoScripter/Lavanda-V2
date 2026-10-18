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
        $db = \Base::instance()->get('DB');

        $themes = array_map(
            fn($row) => $row['name'],
            $db->exec(
                "SELECT t.name
                FROM themes t
                JOIN dices d
                ON d.id = t.themeable_id
                WHERE t.themeable_type = ? AND d.locale = ?
                GROUP BY t.name
                ORDER BY t.name",
                [ThemeableType::DICE->value, $locale]
            )
        );

        view('pages/web/dices', compact('themes'));
    }
}
