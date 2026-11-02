<?php

declare(strict_types=1);

namespace Http\Controllers\Web;

use Http\Controller;

class SSEController extends Controller
{
    public function __invoke(\Base $hive)
    {
        header("X-Accel-Buffering: no");
        header("Content-Type: text/event-stream");
        header("Cache-Control: no-cache");

        while (true) {
            $user = $hive->get('SESSION.user') ?? null;
            $db = $hive->get('DB');

            if (isset($user['id'])) {

                $rows = $db->exec(
                    'SELECT id, content FROM notifications n WHERE n.user = ? LIMIT 1',
                    [$user['id']]
                );

                if (isset($rows[0])) {
                    $data = json_decode($rows[0]['content'], true);

                    $payload = 'data: ';

                    foreach ($data as $sentence) {
                        $payload .= ($sentence . '|');
                    }

                    $db->exec('DELETE FROM notifications WHERE id = ?', [$rows[0]['id']]);

                    echo "event: notification\n",
                    $payload,
                    "\n\n";
                }
            }

            while (ob_get_level() > 0) {
                ob_end_flush();
            }

            flush();

            if (connection_aborted()) break;

            session_write_close();
            sleep(3);
        }
    }
}
