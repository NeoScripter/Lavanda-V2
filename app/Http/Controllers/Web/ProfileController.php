<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Enums\UserRole;
use Http\Controller;
use Support\Auth;
use Traits\RequiresAuth;

class ProfileController extends Controller
{
    use RequiresAuth;

    public function index(\Base $hive)
    {
        $user = Auth::user();

        if ($user['role'] === UserRole::ADMIN->value) {
            $hive->reroute('@home');
        }

        set_values(['email' => $user['email'], 'name' => $user['name']]);

        view('pages/web/profile');
    }
}
