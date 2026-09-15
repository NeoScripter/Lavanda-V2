<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Http\Controller;

class HomeController extends Controller
{
    public function index()
    {
        view('pages/web/home');
    }
}
