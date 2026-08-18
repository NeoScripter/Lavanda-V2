<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Http\Controller;
use Traits\RequiresAuth;

class DashboardController extends Controller
{
    use RequiresAuth;

    public function index(\Base $hive)
    {
        view('pages/admin/dashboard', [
            'title' => $hive->get('Dashboard'),
        ]);
    }
}
