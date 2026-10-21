<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;

class Subscription extends Cortex
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
                "SELECT EXISTS ( SELECT 1 FROM subscriptions s WHERE s.user = ?) AS exists",
                [$self->user->id]
            );

            if ($res[0]['exists']) {
                throw new \InvalidArgumentException('This user already has a subscription');
            }
        });
    }

    protected $fieldConf = [
        'plan_slug' => [
            'type' => Schema::DT_VARCHAR512,
            'nullable' => false,
        ],
        'ends_at' => [
            'type' => Schema::DT_DATE,
            'nullable' => false,
            'default' => Schema::DF_CURRENT_TIMESTAMP,
        ],
        'user' => [
            'belongs-to-one' => "\Http\Models\User"
        ],
        'starts_at' => [
            'type' => Schema::DT_DATE,
            'nullable' => false,
            'default' => Schema::DF_CURRENT_TIMESTAMP,
        ],
    ];

    protected $db = 'DB', $table = 'subscriptions';
}
