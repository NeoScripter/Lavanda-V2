<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Http\Controller;
use Http\Models\Affirmation;
use Support\Session;

class AffirmationController extends Controller
{
    public function index(\Base $hive)
    {
        $locale = Session::get_locale();
        $topic = urldecode($hive->GET['topic']);

        $affirmations = new Affirmation();
        $affirmations = $affirmations->find(
            ['locale=? AND topic=?', $locale, $topic],
            ['order' => 'created_at DESC']
        );

        view('pages/web/affirmations', compact('affirmations'));
    }
}
