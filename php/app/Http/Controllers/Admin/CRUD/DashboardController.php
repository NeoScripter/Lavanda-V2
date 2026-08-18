<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Support\Auth;

class DashboardController
{
    public function beforeroute(\Base $hive)
    {
        if (! Auth::check()) {
            $hive->reroute('@login');
        }
    }

    public function index(\Base $hive)
    {
        view('pages/admin/dashboard', [
            'title' => $hive->get('Dashboard'),
        ]);
    }
}
