<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;

class Image extends Cortex
{
    function __construct()
    {
        parent::__construct();

        $this->beforeerase(function ($self) {
            $src = $self->get('src');
            purge_files($src);
        });
    }

    protected $fieldConf = [
        'variant' => [
            'type' => Schema::DT_VARCHAR256,
            'nullable' => false,
            'default' => 'image',
        ],
        'src' => [
            'type' => Schema::DT_VARCHAR256,
            'nullable' => false,
        ],
        'alt' => [
            'type' => Schema::DT_TEXT,
            'nullable' => false,
        ]
    ];
    protected $db = 'DB', $table = 'images';
}
