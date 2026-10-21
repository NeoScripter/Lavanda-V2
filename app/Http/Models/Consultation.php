<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;

class Consultation extends Cortex
{
    protected $fieldConf = [
        'plan_slug' => [
            'type' => Schema::DT_VARCHAR512,
            'nullable' => false,
        ],
        'type' => [
            'type' => Schema::DT_VARCHAR128,
            'nullable' => false,
        ],
        'number' => [
            'type' => Schema::DT_INT4,
            'nullable' => false,
            'default' => 0,
        ],
        'user' => [
            'belongs-to-one' => "\User"
        ],
        'created_at' => [
            'type' => Schema::DT_DATE,
            'nullable' => false,
            'default' => Schema::DF_CURRENT_TIMESTAMP,
        ],
    ];

    protected $db = 'DB', $table = 'consultations';
}
