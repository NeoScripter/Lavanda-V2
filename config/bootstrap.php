<?php

declare(strict_types=1);

use DB\SQL;

require APP_DIR . '/vendor/autoload.php';

$hive = Base::instance();

load_env_vars();

$hive->set('AUTOLOAD', APP_DIR . '/app/;' . APP_DIR . '/db/;');
$hive->set('UI', APP_DIR . '/ui/views/');
$hive->set('LOGS', APP_DIR . '/storage/logs/');
define('UPLOAD_DIR', APP_DIR . '/public/storage/uploads/');
define('WEBROOT', APP_DIR . '/public/');

$db_host = getenv('DB_HOST');
$db_name = getenv('DB_NAME');
$db_user = getenv('DB_USER');
$db_pw = getenv('DB_PASSWORD');
$db_port = getenv('DB_PORT');

$db = new SQL(
    "pgsql:host={$db_host};port={$db_port};dbname={$db_name}",
    "{$db_user}",
    "{$db_pw}"
);

$hive->set('DB', $db);

require APP_DIR . '/config/session.php';

$hive->config(APP_DIR . '/config/routes.ini');

// $hive->set('DEBUG', $hive->get('app_debug') ? 3 : 0);
$hive->set('DEBUG',  3);
$hive->set('LOCALES', APP_DIR . '/ui/data/dict/');

$queue = new n0nag0n\Job_Queue('pgsql');
$queue->addQueueConnection($hive->get('DB')->pdo());
$hive->set('JOB_QUEUE', $queue);


$hive->run();
