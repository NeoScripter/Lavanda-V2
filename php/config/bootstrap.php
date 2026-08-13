<?php

declare(strict_types=1);

require APP_DIR . '/vendor/autoload.php';

$hive = Base::instance();

$hive->set('AUTOLOAD', APP_DIR . '/app/;' . APP_DIR . '/db/;');
$hive->set('UI', APP_DIR . '/ui/views/');
$hive->set('LOGS', APP_DIR . '/storage/logs/');
define('UPLOAD_DIR', APP_DIR . '/storage/public/uploads/');

$hive->config(APP_DIR . '/config/env.ini');

require APP_DIR . '/config/session.php';

$hive->config(APP_DIR . '/config/routes.ini');

if (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https') {
    $_SERVER['HTTPS'] = 'on';
}
$hive->set('SCHEME', ($_SERVER['HTTPS'] ?? 'off') !== 'off' ? 'https' : 'http');

$hive->set('DEBUG', $hive->get('app_debug') ? 3 : 0);
$hive->set('LOCALES', APP_DIR . '/ui/data/dict/');

require APP_DIR . '/config/exception_config.php';

$hive->set('db_name', getenv('DB_NAME'));
$hive->set('db_host', getenv('DB_HOST'));
$hive->set('db_password', getenv('DB_PASSWORD'));
$hive->set('db_user', getenv('DB_USER'));

require APP_DIR . '/config/database.php';
require APP_DIR . '/config/queue.php';

$hive->run();
