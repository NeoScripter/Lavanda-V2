<?php

declare(strict_types=1);

namespace Traits;

use Enums\UserRole;
use Support\Auth;

trait RequiresAdminRights
{
    public function beforeroute(\Base $hive)
    {
        if (! Auth::check()) {
            $hive->reroute('@admin_login');
        }

        $user = Auth::user();

        if ($user['role'] !== UserRole::ADMIN->value) {
            $hive->reroute('@admin_login');
        }
    }
}
