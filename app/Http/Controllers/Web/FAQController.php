<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Http\Controller;
use Http\Models\FAQ;
use Support\Session;

class FAQController extends Controller
{
    public function index()
    {
        $locale = Session::get_locale();

        $faqs = new FAQ();
        $faqs = $faqs->find(
            ['locale=?', $locale],
            ['order' => 'created_at DESC']
        );

        view('pages/web/faqs', compact('faqs'));
    }
}
