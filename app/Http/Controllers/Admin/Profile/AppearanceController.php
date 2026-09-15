<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\Profile;

use Http\Controller;
use Traits\RequiresAuth;

class AppearanceController extends Controller
{
    use RequiresAuth;

    public function index()
    {
        view('pages/admin/appearance', [
            'title' => 'Appearance',
        ]);
    }
}
