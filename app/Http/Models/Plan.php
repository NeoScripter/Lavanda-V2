<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;

class Plan extends Cortex
{
    protected $fieldConf = [
        'slug' => [
            'type' => Schema::DT_VARCHAR512,
            'nullable' => false,
        ],
        'is_active' => [
            'type' => Schema::DT_BOOLEAN,
            'nullable' => false,
            'default' => true,
        ],
        'price' => [
            'type' => Schema::DT_INT8,
            'nullable' => false,
        ],
        'created_at' => [
            'type' => Schema::DT_DATE,
            'nullable' => false,
            'default' => Schema::DF_CURRENT_TIMESTAMP,
        ],
    ];

    protected $db = 'DB', $table = 'plans';
}
