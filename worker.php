<?php

use DB\SQL;

require __DIR__ . '/vendor/autoload.php';

$hive = Base::instance();

define('APP_DIR', __DIR__);
define('WEBROOT', APP_DIR . '/public/');

error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

$hive->set('AUTOLOAD', APP_DIR . '/app/;' . APP_DIR . '/db/;');

load_env_vars();

$db_host = getenv('DB_HOST');
$db_name = getenv('DB_NAME');
$db_user = getenv('DB_USER');
$db_pw = getenv('DB_PASSWORD');
$db_port = getenv('DB_PORT');

$db = new SQL(
    "pgsql:host={$db_host};port={$db_port};dbname={$db_name}",
    "{$db_user}",
    "{$db_pw}"
);

$hive->set('DB', $db);

$queue = new n0nag0n\Job_Queue('pgsql');
$queue->addQueueConnection($hive->get('DB')->pdo());
$hive->set('JOB_QUEUE', $queue);

$queue = $hive->get('JOB_QUEUE');
$queue->watchPipeline('run_processes');


while (true) {
    $job = $queue->getNextJobAndReserve();
    if (empty($job)) {
        usleep(500000);
        continue;
    }

    echo "Processing {$job['id']}\n";
    $envelope = json_decode($job['payload'], true);

    try {
        if (!is_array($envelope) || !isset($envelope['job_class'], $envelope['payload'])) {
            throw new \Exception('Malformed job envelope (missing job_class/payload)');
        }

        $jobClass = $envelope['job_class'];

        if (!class_exists($jobClass) || !is_subclass_of($jobClass, \Jobs\Job::class)) {
            throw new \Exception("Invalid or unknown job class: {$jobClass}");
        }

        (new $jobClass())->handle($envelope['payload']);
        $queue->deleteJob($job);
    } catch (\Throwable $e) {
        echo ("Job {$job['id']} failed: {$e->getMessage()}");
        $queue->buryJob($job);
    }
}
