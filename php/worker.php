<?php

require __DIR__ . '/vendor/autoload.php';

$hive = Base::instance();

define('APP_DIR', __DIR__);

error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

$hive->config(APP_DIR . '/config/env.ini');
$hive->set('AUTOLOAD', APP_DIR . '/app/;' . APP_DIR . '/db/;');

require APP_DIR . '/config/database.php';

$pdo = $hive->get('DB')->pdo();

$queue = new n0nag0n\Job_Queue('pgsql');
$queue->addQueueConnection($pdo);
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
        $logger = new \Log('./storage/logs/worker.log');
        $logger->write("Job {$job['id']} failed: {$e->getMessage()}");
        $queue->buryJob($job);
    }
}
