<?php

declare(strict_types=1);

namespace Http\Controllers\Admin;

use Support\Auth;

class DashboardController
{
    public function beforeroute(\Base $hive)
    {
        if (! Auth::check()) {
            $hive->reroute('@login');
        }
    }

    public function index()
    {
        view('pages/admin/dashboard', [
            'title' => 'Dashboard',
        ]);
    }
}
