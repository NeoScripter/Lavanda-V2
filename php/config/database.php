<?php

use DB\SQL;

$hive = Base::instance();

$db = new SQL(
    "pgsql:host={$hive->get('db_host')};port={$hive->get('db_port')};dbname={$hive->get('db_name')}",
    "{$hive->get('db_user')}",
    "{$hive->get('db_password')}"
);

$hive->set('DB', $db);
