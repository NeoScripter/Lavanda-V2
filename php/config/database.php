<?php

use DB\SQL;

$hive = Base::instance();

$hive->set('db_name', getenv('DB_NAME'));
$hive->set('db_host', getenv('DB_HOST'));
$hive->set('db_port', 5432);
$hive->set('db_password', getenv('DB_PASSWORD'));
$hive->set('db_user', getenv('DB_USER'));

$db = new SQL(
    "pgsql:host={$hive->get('db_host')};port={$hive->get('db_port')};dbname={$hive->get('db_name')}",
    "{$hive->get('db_user')}",
    "{$hive->get('db_password')}"
);

$hive->set('DB', $db);
