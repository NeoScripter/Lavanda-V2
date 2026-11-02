<?php

use Support\Auth;
use Support\AccessStatus;

session_start();

header("X-Accel-Buffering: no");
header("Content-Type: text/event-stream");
header("Cache-Control: no-cache");

$tick = 2;
// $user = Auth::user();

// $initial_active_plans = (empty($user) ? 0 : AccessStatus::get_accessed_plans_num($user));
$initial_active_plans = 0;
// if ($hive->exists('SESSION.ACTIVE_PLANS')) {
//     // $initial_active_plans = (int) $hive->get('SESSION.ACTIVE_PLANS');
// } else {
//     $initial_active_plans = (empty($user) ? 0 : AccessStatus::get_accessed_plans_num($user));
//     // $hive->set('SESSION.ACTIVE_PLANS', $initial_active_plans);
// }

while (true) {
    $tick--;

    if ($tick === 0) {
        $payload = 'data: ';

        // var_dump($_COOKIE['PHPSESSID']);
        var_dump($_SESSION);
        dd(count($_COOKIE));
        // $updated_active_plans  = empty($user) ? 0 : AccessStatus::get_accessed_plans_num($user);
        // if ($updated_active_plans > $initial_active_plans) {

        $data = ['Покупка прошла успешно!', 'Доступ к платным разделам сайта открыт.', 'Хорошего вам дня и настроения!'];

        $payload = 'data: ';

        foreach ($data as $sentence) {
            $payload .= ($sentence . '|');
        }

        echo "event: subscribed\n",
        $payload,
        "\n\n";

        $initial_active_plans = $updated_active_plans;
        // $hive->set('SESSION.ACTIVE_PLANS', $updated_active_plans);
        // }
        $tick = 10;
    }

    while (ob_get_level() > 0) {
        ob_end_flush();
    }
    flush();

    if (connection_aborted()) break;

    sleep(1);
    session_write_close();
}
