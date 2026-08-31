<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;
use Enums\Locale;

class Affirmation extends Cortex
{

    protected $fieldConf = [
        'quote' => [
            'type' => Schema::DT_TEXT,
            'nullable' => false,
        ],
        'topic' => [
            'type' => Schema::DT_VARCHAR256,
            'index' => true,
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

    protected $db = 'DB', $table = 'affirmations';
}
