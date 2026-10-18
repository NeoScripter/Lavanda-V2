<?php

declare(strict_types=1);

namespace Http\Controllers\Api;

use Enums\ThemeableType;
use Http\Controller;
use Support\Session;

class DiceController extends Controller
{
    public function __invoke(\Base $hive)
    {
        $locale = Session::get_locale();
        $theme  = urldecode($hive->GET['theme']);
        $winner_id = urldecode($hive->GET['winner_id']);

        $db = $hive->get('DB');

        $rows = $db->exec(
            "SELECT t.html FROM themes t 
            JOIN dices d ON d.id = t.themeable_id 
            WHERE t.themeable_type = ? AND LOWER(t.name) = ? AND d.diceable_id = ? AND d.locale = ?",
            [ThemeableType::DICE->value, $theme, $winner_id, $locale]
        );

        if (empty($rows[0]['html'])) {
            send_json(['message' =>  "Could not find the requested html with this theme"], 400);
        }

        $payload = ['html' => \Markdown::instance()->convert($rows[0]['html'])];

        send_json($payload);
    }
}
