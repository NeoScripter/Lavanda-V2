<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;
use Enums\Locale;

class FAQ extends Cortex
{

    protected $fieldConf = [
        'question' => [
            'type' => Schema::DT_TEXT,
            'nullable' => false,
        ],
        'answer' => [
            'type' => Schema::DT_TEXT,
            'nullable' => false,
        ],
        'locale' => [
            'type' => Schema::DT_VARCHAR128,
            'default' => Locale::ENGLISH->value,
            'nullable' => false,
        ],
        'created_at' => [
            'type' => Schema::DT_DATE,
            'nullable' => false,
            'default' => Schema::DF_CURRENT_TIMESTAMP,
        ],
    ];

    protected $db = 'DB', $table = 'faqs';
}
