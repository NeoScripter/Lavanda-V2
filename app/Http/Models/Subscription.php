<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;

class Subscription extends Cortex
{
    protected $fieldConf = [
        'plan_slug' => [
            'type' => Schema::DT_VARCHAR512,
            'nullable' => false,
        ],
        'ends_at' => [
            'type' => Schema::DT_DATE,
            'nullable' => false,
            'default' => Schema::DF_CURRENT_TIMESTAMP,
        ],
        'user' => [
            'belongs-to-one' => "\User"
        ],
        'starts_at' => [
            'type' => Schema::DT_DATE,
            'nullable' => false,
            'default' => Schema::DF_CURRENT_TIMESTAMP,
        ],
    ];

    protected $db = 'DB', $table = 'subscriptions';
}
