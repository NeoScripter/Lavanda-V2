<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;

class Notification extends Cortex
{
    protected $fieldConf = [
        'content' => [
            'type' => self::DT_JSON,
            'nullable' => false,
        ],
        'expires_at' => [
            'type' => Schema::DT_DATE,
            'nullable' => false,
            'default' => Schema::DF_CURRENT_TIMESTAMP,
        ],
        'user' => [
            'belongs-to-one' => "\Http\Models\User"
        ],
        'created_at' => [
            'type' => Schema::DT_DATE,
            'nullable' => false,
            'default' => Schema::DF_CURRENT_TIMESTAMP,
        ],
    ];

    protected $db = 'DB', $table = 'notifications';
}
