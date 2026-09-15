<?php

$hive = \Base::instance();

// General

$hive->set('app_name', "Lavanda");
$hive->set('app_env', getenv('APP_ENV'));
$hive->set('app_debug', (bool) getenv('APP_DEBUG'));
$hive->set('app_url', getenv('PHP_APP_URL'));

// Database

$hive->set('db_name', getenv('DB_NAME'));
$hive->set('db_host', getenv('DB_HOST'));
$hive->set('db_port', 5432);
$hive->set('db_password', getenv('DB_PASSWORD'));
$hive->set('db_user', getenv('DB_USER'));
