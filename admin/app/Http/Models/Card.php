<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;
use Enums\Locale;

class Card extends Cortex
{
    protected $fieldConf = [
        'name' => [
            'type' => Schema::DT_VARCHAR256,
            'nullable' => false,
        ],
        'html' => [
            'type' => Schema::DT_VARCHAR128,
            'index' => true,
            'unique' => true,
            'nullable' => false,
        ],
        'advice' => [
            'type' => Schema::DT_TEXT,
            'nullable' => false,
        ],
        'variant' => [
            'type' => Schema::DT_VARCHAR128,
            'nullable' => false,
        ],
        'locale' => [
            'type' => Schema::DT_VARCHAR128,
            'default' => Locale::ENGLISH->value,
            'nullable' => false,
        ],
    ];
    protected $db = 'DB', $table = 'cards';
}
