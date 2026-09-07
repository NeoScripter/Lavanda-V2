<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;
use Enums\Locale;

class MatchSet extends Cortex
{
    protected $fieldConf = [
        'matcheable_type' => [
            'type' => Schema::DT_VARCHAR128,
            'nullable' => false,
        ],
        'matcheable_id' => [
            'type' => Schema::DT_VARCHAR256,
            'index' => true,
            'nullable' => false,
            'default' => '',
        ],
        'locale' => [
            'type' => Schema::DT_VARCHAR128,
            'default' => Locale::RUSSIAN->value,
            'nullable' => false,
        ],
        'advice' => [
            'type' => Schema::DT_TEXT,
            'nullable' => false,
        ],
        'html' => [
            'type' => Schema::DT_TEXT,
            'nullable' => false,
        ],
        'created_at' => [
            'type' => Schema::DT_DATE,
            'nullable' => false,
            'default' => Schema::DF_CURRENT_TIMESTAMP,
        ],
    ];

    protected $db = 'DB', $table = 'match_sets';
}
