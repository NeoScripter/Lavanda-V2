<?php

declare(strict_types=1);

require APP_DIR . '/vendor/autoload.php';

$hive = Base::instance();

$hive->set('AUTOLOAD', APP_DIR . '/app/;' . APP_DIR . '/db/;');
$hive->set('UI', APP_DIR . '/ui/views/');
$hive->set('LOGS', APP_DIR . '/storage/logs/');
define('UPLOAD_DIR', APP_DIR . '/public/storage/uploads/');
define('WEBROOT', APP_DIR . '/public/');

require APP_DIR . '/config/globals.php';
require APP_DIR . '/config/session.php';

$hive->config(APP_DIR . '/config/routes.ini');

// $hive->set('DEBUG', $hive->get('app_debug') ? 3 : 0);
$hive->set('DEBUG',  3);
$hive->set('LOCALES', APP_DIR . '/ui/data/dict/');

// require APP_DIR . '/config/exception_config.php';

require APP_DIR . '/config/database.php';
require APP_DIR . '/config/queue.php';

$hive->run();
