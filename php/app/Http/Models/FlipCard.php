<?php

namespace Http\Models;

use DB\SQL\Mapper;

class FlipCard extends Mapper
{
    function __construct()
    {
        $db = \Base::instance()->get("DB");

        parent::__construct($db, 'flip_cards');
    }
}
