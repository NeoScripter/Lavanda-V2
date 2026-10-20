<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\Profile;

use Http\Controller;
use Traits\RequiresAdminRights;

class AppearanceController extends Controller
{
    use RequiresAdminRights;

    public function index()
    {
        view('pages/admin/appearance', [
            'title' => 'Appearance',
        ]);
    }
}
