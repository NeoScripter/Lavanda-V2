<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;
use Enums\Locale;

class Iching extends Cortex
{
    protected $fieldConf = [

        'bitmask' => [
            'type' => Schema::DT_INT,
            'nullable' => false,
        ],
        'number' => [
            'type' => Schema::DT_INT,
            'nullable' => false,
        ],
        'description' => [
            'type' => Schema::DT_TEXT,
            'nullable' => false,
        ],
        'locale' => [
            'type' => Schema::DT_VARCHAR128,
            'default' => Locale::RUSSIAN->value,
            'nullable' => false,
        ],
        'created_at' => [
            'type' => Schema::DT_DATE,
            'nullable' => false,
            'default' => Schema::DF_CURRENT_TIMESTAMP,
        ],
    ];

    protected $db = 'DB', $table = 'ichings';
}
