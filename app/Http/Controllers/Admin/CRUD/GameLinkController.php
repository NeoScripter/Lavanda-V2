<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Enums\AppEnv;
use Http\Controller;
use Traits\RequiresAdminRights;

class GameLinkController extends Controller
{
    use RequiresAdminRights;

    public function __invoke(\Base $hive)
    {
        if (! AppEnv::is(AppEnv::TESTING)) {
            check_csrf($hive->POST);
        }

        $request = array_slice($hive->POST, 2);

        $map = "";

        $from = null;
        foreach ($request as $route) {
            if ($from === null) {
                $from = $route;
            } else {
                $map .= (PHP_EOL . "$from -> $route");
                $from = null;
            }
        }

        $file = fopen(APP_DIR . '/ui/data/models/game-links.txt', "w");
        fwrite($file, $map);

        notify($hive->get('admin.game_links_updated'));

        $hive->reroute($hive->alias('dashboard'));
    }
}
