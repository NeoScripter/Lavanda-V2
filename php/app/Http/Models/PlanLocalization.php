<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;
use Enums\Locale;

class PlanLocalization extends Cortex
{
    protected $fieldConf = [
        'name' => [
            'type' => Schema::DT_VARCHAR512,
            'nullable' => false,
        ],
        'html' => [
            'type' => Schema::DT_TEXT,
            'nullable' => false,
        ],
        'price' => [
            'type' => Schema::DT_INT4,
            'nullable' => false,
        ],
        'currency' => [
            'type' => Schema::DT_VARCHAR128,
            'nullable' => false,
        ],
        'locale' => [
            'type' => Schema::DT_VARCHAR128,
            'default' => Locale::RUSSIAN->value,
            'nullable' => false,
        ],
        'plan' => [
            'belongs-to-one' => "\Plan"
        ],
        'created_at' => [
            'type' => Schema::DT_DATE,
            'nullable' => false,
            'default' => Schema::DF_CURRENT_TIMESTAMP,
        ],
    ];

    protected $db = 'DB', $table = 'plan_localizations';
}
