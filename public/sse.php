<?php
header("X-Accel-Buffering: no");
header("Content-Type: text/event-stream");
header("Cache-Control: no-cache");

$last_run = time();


while (true) {

    // if (time() < ($last_run + 2)) {
    //     usleep(200_000);
    //     continue;
    // }

    $last_run = time();
    session_start();

    $session = $_SESSION;
    $user = $session['user'] ?? null;

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
    sleep(3);
}
