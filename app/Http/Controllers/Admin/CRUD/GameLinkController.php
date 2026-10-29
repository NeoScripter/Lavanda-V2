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

        $json = [];

        $from = null;
        $idx = 0;
        foreach ($request as $route) {
            $idx++;
            if ($from === null) {
                $from = $route;
            } else {
                $json["$idx$from"] = "$idx$route";
                $from = null;
            }
        }

        $file = fopen(APP_DIR . '/ui/data/models/game-links.json', "w");
        fwrite($file, json_encode($json));

        notify($hive->get('admin.game_links_updated'));

        $hive->reroute($hive->alias('dashboard'));
    }
}
