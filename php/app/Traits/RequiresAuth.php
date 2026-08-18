<?php

declare(strict_types=1);

namespace Traits;

use Support\Auth;

trait RequiresAuth
{
    public function beforeroute(\Base $hive)
    {
        if (! Auth::check()) {
            $hive->reroute('@login');
        }
    }
}
