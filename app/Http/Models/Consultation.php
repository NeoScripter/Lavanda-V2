<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;

class Consultation extends Cortex
{
    function __construct()
    {
        parent::__construct();

        $this->beforesave(function ($self) {

            if (empty($self->user)) {
                return;
            }

            $db = \Base::instance()->get('DB');

            $res = $db->exec(
                "SELECT EXISTS ( SELECT 1 FROM consultations c WHERE c.user = ?) AS exists",
                [$self->user->id]
            );

            if ($res[0]['exists']) {
                throw new \InvalidArgumentException('This user already has a consultation');
            }
        });
    }

    protected $fieldConf = [
        'plan_slug' => [
            'type' => Schema::DT_VARCHAR512,
            'nullable' => false,
        ],
        'type' => [
            'type' => Schema::DT_VARCHAR128,
            'nullable' => false,
        ],
        'number' => [
            'type' => Schema::DT_INT4,
            'nullable' => false,
            'default' => 0,
        ],
        'user' => [
            'belongs-to-one' => "\Http\Models\User"
        ],
        'created_at' => [
            'type' => Schema::DT_DATE,
            'nullable' => false,
            'default' => Schema::DF_CURRENT_TIMESTAMP,
        ],
    ];

    protected $db = 'DB', $table = 'consultations';
}
