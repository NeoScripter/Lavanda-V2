<?php

$hive = Base::instance();

$queue = new n0nag0n\Job_Queue($hive->get('db_connection'));
$queue->addQueueConnection($hive->get('DB')->pdo());
$hive->set('JOB_QUEUE', $queue);
