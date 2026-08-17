<?php

// error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

require_once __DIR__ . '/../vendor/autoload.php';

define('APP_DIR', dirname(__DIR__));
define('UPLOAD_DIR', APP_DIR . '/public/storage/test_uploads/');
define('WEBROOT', APP_DIR . '/public/');

if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0777, true);
}

$hive = Base::instance();

$hive->set('AUTOLOAD', APP_DIR . '/app/;' . APP_DIR . '/db/;');
require APP_DIR . '/config/globals.php';
$hive->config(APP_DIR . '/config/routes.ini');

$hive->set('db_name', getenv('TEST_DB_NAME'));
$hive->set('db_port', (int) getenv('TEST_DB_PORT'));
$hive->set('db_host', getenv('TEST_DB_HOST'));
$hive->set('db_password', getenv('TEST_DB_PASSWORD'));
$hive->set('db_user', getenv('TEST_DB_USER'));

require APP_DIR . '/config/database.php';
