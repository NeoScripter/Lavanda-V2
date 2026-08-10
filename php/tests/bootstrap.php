<?php

// error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

require_once __DIR__ . '/../vendor/autoload.php';

define('APP_DIR', dirname(__DIR__));
define('UPLOAD_DIR', APP_DIR . '/public/storage/test_uploads/');

if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0777, true);
}

$hive = Base::instance();

$hive->set('AUTOLOAD', APP_DIR . '/app/;' . APP_DIR . '/db/;');
$hive->config(APP_DIR . '/config/env.ini');
$hive->config(APP_DIR . '/config/routes.ini');
