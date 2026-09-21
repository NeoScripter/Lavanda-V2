<?php

use DB\SQL;
use Enums\AppEnv;

error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

require_once __DIR__ . '/../vendor/autoload.php';

define('APP_DIR', dirname(__DIR__));
define('UPLOAD_DIR', APP_DIR . '/public/storage/test_uploads/');
define('WEBROOT', APP_DIR . '/public/');

load_env_vars();

if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0777, true);
}

$hive = Base::instance();

$hive->set('AUTOLOAD', APP_DIR . '/app/;' . APP_DIR . '/db/;');
$hive->config(APP_DIR . '/config/routes.ini');

putenv('APP_ENV='. AppEnv::TESTING->value);

$db_host = getenv('TEST_DB_HOST');
$db_name = getenv('TEST_DB_NAME');
$db_user = getenv('TEST_DB_USER');
$db_pw = getenv('TEST_DB_PASSWORD');
$db_port = getenv('TEST_DB_PORT');

$db = new SQL(
    "pgsql:host={$db_host};port={$db_port};dbname={$db_name}",
    "{$db_user}",
    "{$db_pw}"
);

$hive->set('DB', $db);
