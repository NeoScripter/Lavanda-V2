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
        'src' => [
            'type' => Schema::DT_VARCHAR256,
            'nullable' => false,
        ],
        'imageable_type' => [
            'type' => Schema::DT_VARCHAR128,
            'nullable' => false,
        ],
        'imageable_id' => [
            'type' => Schema::DT_INT,
            'nullable' => false,
        ],
        'variant' => [
            'type' => Schema::DT_VARCHAR256,
            'nullable' => false,
            'default' => 'image',
        ],
        'alt' => [
            'type' => Schema::DT_TEXT,
            'nullable' => false,
        ],
        'created_at' => [
            'type' => Schema::DT_DATE,
            'nullable' => false,
            'default' => Schema::DF_CURRENT_TIMESTAMP,
        ],
    ];

    protected $db = 'DB', $table = 'images';
}
