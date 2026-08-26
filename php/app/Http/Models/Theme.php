<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;
use InvalidArgumentException;

class Theme extends Cortex
{
    function __construct()
    {
        parent::__construct();

        $this->beforeinsert(function ($self) {
            $db = \Base::instance()->get('DB');

            $res = $db->exec(
                "SELECT EXISTS ( SELECT 1 FROM themes WHERE themeable_type = ? AND themeable_id = ? AND name = ?) AS exists",
                [$self->themeable_type, $self->themeable_id, $self->name]
            );

            if ($res[0]['exists']) {
                throw new InvalidArgumentException('Theme already exists for this parent');
            }
        });
    }

    protected $fieldConf = [
        'name' => [
            'type' => Schema::DT_VARCHAR256,
            'index' => true,
            'nullable' => false,
        ],
        'themeable_type' => [
            'type' => Schema::DT_VARCHAR128,
            'nullable' => false,
        ],
        'themeable_id' => [
            'type' => Schema::DT_INT,
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

    protected $db = 'DB', $table = 'themes';
}
