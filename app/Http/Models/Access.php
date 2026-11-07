<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;
use Log;

class Access extends Cortex
{
    function __construct()
    {
        parent::__construct();

        $this->beforeinsert(function ($self) {

            if (empty($self->user)) {
                return;
            }

            $db = \Base::instance()->get('DB');

            $res = $db->exec(
                "SELECT EXISTS ( SELECT 1 FROM accesses a WHERE a.user = ?) AS exists",
                [$self->user->id]
            );

            if ($res[0]['exists']) {
                $error_msg = 'This user already has an access';
                $logger = new Log('storage/logs/error.log');
                $logger->write($error_msg . ' user id:' . $self->user->id, format: 'd-m-Y H:i:s');
                throw new \InvalidArgumentException($error_msg);
            }
        });
    }

    protected $fieldConf = [
        'active_games' => [
            'type' => Schema::DT_INT4,
            'nullable' => false,
            'default' => 0,
        ],
        'active_consultations' => [
            'type' => Schema::DT_INT4,
            'nullable' => false,
            'default' => 0,
        ],
        'subscription_ends_at' => [
            'type' => Schema::DT_DATE,
            'nullable' => false,
            'default' => Schema::DF_CURRENT_TIMESTAMP,
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

    protected $db = 'DB', $table = 'accesses';
}
