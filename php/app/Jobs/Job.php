<?php

declare(strict_types=1);

namespace Jobs;

use Base;

abstract class Job
{
    /**
     * @param array $payload
     */
    abstract public function handle(array $payload): void;

    public static function dispatch(array $payload): void
    {
        $queue = Base::instance()->get('JOB_QUEUE');
        $queue->selectPipeline('run_processes');
        $queue->addJob(json_encode([
            'job_class' => static::class,
            'payload'   => $payload,
        ]));
    }
}
