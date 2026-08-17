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


$hive->set('app_env', 'development');
$hive->set('app_debug', true);
$hive->set('app_url', 'http://localhost:9001/admin/');

$hive->set('db_name', "test_db");
$hive->set('db_host', "localhost");
$hive->set('db_post', "5432");
$hive->set('db_password', "password");
$hive->set('db_user', "ilya");

require APP_DIR . '/config/database.php';
