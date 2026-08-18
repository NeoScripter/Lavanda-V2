<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\Profile;

use Support\Auth;

class AppearanceController
{
    public function beforeroute(\Base $hive)
    {
        if (! Auth::check()) {
            $hive->reroute('@login');
        }
    }

    public function index()
    {
        view('pages/admin/appearance', [
            'title' => 'Appearance',
        ]);
    }
}
