<?php

declare(strict_types=1);

require APP_DIR . '/vendor/autoload.php';

$hive = Base::instance();

$hive->set('AUTOLOAD', APP_DIR . '/app/;' . APP_DIR . '/db/;');
$hive->set('UI', APP_DIR . '/ui/views/');
$hive->set('LOGS', APP_DIR . '/storage/logs/');
define('UPLOAD_DIR', APP_DIR . '/public/storage/uploads/');

$hive->config(APP_DIR . '/config/env.ini');

$hive->set('CACHE', "redis={$hive->get('redis_host')}:{$hive->get('redis_port')}");

$session = new Session(function () {
    return true;
});

if (! $hive->exists('SESSION.csrf')) {
    $hive->set('SESSION.csrf', $session->csrf());
}

$hive->copy('SESSION.csrf', 'CSRF');

$hive->config(APP_DIR . '/config/routes.ini');

$hive->set('DEBUG', $hive->get('app_debug') ? 3 : 0);

require APP_DIR . '/config/exception_config.php';
require APP_DIR . '/config/database.php';

$queue = new n0nag0n\Job_Queue('pgsql');
$queue->addQueueConnection($hive->get('DB')->pdo());
$hive->set('JOB_QUEUE', $queue);

$flash = \Flash::instance();
$hive->set('FLASH', $flash);

$hive->run();
