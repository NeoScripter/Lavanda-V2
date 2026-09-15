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
        'subscription_type' => [
            'type' => Schema::DT_VARCHAR128,
            'nullable' => false,
        ],
        'localizations' => [
            'has-many' => ["\PlanLocalization", "plan"],
        ],
        'created_at' => [
            'type' => Schema::DT_DATE,
            'nullable' => false,
            'default' => Schema::DF_CURRENT_TIMESTAMP,
        ],
    ];

    protected $db = 'DB', $table = 'plans';
}
