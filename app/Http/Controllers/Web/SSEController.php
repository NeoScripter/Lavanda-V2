<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Http\Controller;
use Support\AccessStatus;
use Support\Auth;

class SSEController extends Controller
{
    public function __invoke(\Base $hive)
    {
        header("X-Accel-Buffering: no");
        header("Content-Type: text/event-stream");
        header("Cache-Control: no-cache");

        while (true) {
            $user = $hive->get('SESSION.user') ?? null;

            if (! empty($user)) {
                $user_name = ($user['name'] ?? 'unknown');

                $data = ['Покупка прошла успешно!', 'Доступ к платным разделам сайта открыт.', 'Хорошего вам дня и настроения!'];

                $payload = 'data: ';

                foreach ($data as $sentence) {
                    $payload .= ($sentence . '|');
                }

                $payload .= ($user_name);

                echo "event: subscribed\n",
                $payload,
                "\n\n";
            }

            while (ob_get_level() > 0) {
                ob_end_flush();
            }

            flush();

            if (connection_aborted()) break;

            session_write_close();
            sleep(8);
        }
    }

    public function backup(\Base $hive)
    {
        header("X-Accel-Buffering: no");
        header("Content-Type: text/event-stream");
        // header("Cache-Control: no-cache");

        $tick = 10;
        $user = Auth::user();

        $initial_active_plans = (empty($user) ? 0 : AccessStatus::get_accessed_plans_num($user));
        // if ($hive->exists('SESSION.ACTIVE_PLANS')) {
        //     // $initial_active_plans = (int) $hive->get('SESSION.ACTIVE_PLANS');
        // } else {
        //     $initial_active_plans = (empty($user) ? 0 : AccessStatus::get_accessed_plans_num($user));
        //     // $hive->set('SESSION.ACTIVE_PLANS', $initial_active_plans);
        // }

        while (true) {
            $tick--;

            if ($tick === 0) {
                $updated_active_plans  = empty($user) ? 0 : AccessStatus::get_accessed_plans_num($user);
                if ($updated_active_plans > $initial_active_plans) {

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
                }
                $tick = 10;
            }

            while (ob_get_level() > 0) {
                ob_end_flush();
            }
            flush();

            if (connection_aborted()) break;

            sleep(5);
        }
    }
}
