<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Http\Controller;

class PageController extends Controller
{
    public function __invoke(\Base $hive, array $params)
    {
        $view = $params['view'];
        view("pages/web/$view");
    }
}
