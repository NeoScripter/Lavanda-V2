<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;
use Enums\Locale;
use InvalidArgumentException;

class MatchSet extends Cortex
{
    function __construct()
    {
        parent::__construct();

        $this->beforeinsert(function ($self) {
            $db = \Base::instance()->get('DB');

            $res = $db->exec(
                "SELECT EXISTS ( SELECT 1 FROM themes WHERE matcheable_type = ? AND matcheable_id = ?) AS exists",
                [$self->matcheable_type, $self->matcheable_id]
            );

            if ($res[0]['exists']) {
                throw new InvalidArgumentException('MatchSet already exists for this element');
            }
        });
    }

    protected $fieldConf = [
        'matcheable_type' => [
            'type' => Schema::DT_VARCHAR128,
            'nullable' => false,
        ],
        'matcheable_id' => [
            'type' => Schema::DT_VARCHAR256,
            'index' => true,
            'nullable' => false,
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

    protected $db = 'DB', $table = 'themes';
}
