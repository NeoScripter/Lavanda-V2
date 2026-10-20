<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Http\Controller;
use Traits\RequiresAdminRights;

class DashboardController extends Controller
{
    use RequiresAdminRights;

    public function index(\Base $hive)
    {
        view('pages/admin/dashboard', [
            'title' => $hive->get('Dashboard'),
        ]);
    }
}
