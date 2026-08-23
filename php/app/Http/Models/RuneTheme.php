<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;

class RuneTheme extends Cortex
{
    protected $fieldConf = [
        'name' => [
            'type' => Schema::DT_VARCHAR256,
            'index' => true,
            'nullable' => false,
        ],
        'html' => [
            'type' => Schema::DT_TEXT,
            'nullable' => false,
        ],
        'rune' => [
            'belongs-to-one' => '\Http\Models\Rune',
        ],
    ];

    protected $db = 'DB', $table = 'rune_themes';
}
