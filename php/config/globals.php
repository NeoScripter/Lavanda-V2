<?php

$hive = \Base::instance();

$hive->set('app_name', "Lavanda");
$hive->set('app_env', getenv('APP_ENV'));
$hive->set('app_debug', getenv('APP_DEBUG'));
$hive->set('app_url', getenv('PHP_APP_URL'));
$hive->set('db_port', (int) getenv('DB_PORT'));
$hive->set('db_host', getenv('DB_HOST'));
