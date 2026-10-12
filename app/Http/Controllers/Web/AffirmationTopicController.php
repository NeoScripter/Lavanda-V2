<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Http\Controller;
use Support\Session;

class AffirmationTopicController extends Controller
{
    public function index(\Base $hive)
    {
        $locale = Session::get_locale();

        $db = $hive->get("DB");
        $rows = $db->exec("SELECT DISTINCT topic FROM affirmations WHERE locale = ?", [$locale]);
        $topics = [];

        foreach ($rows as $row) {
            $topics[] = $row['topic'];
        }

        view('pages/web/affirmation-topics', compact('topics'));
    }
}
