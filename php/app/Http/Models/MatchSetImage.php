<?php

namespace Http\Models;

use DB\SQL\Mapper;
use Enums\DBView;

class MatchSetImage extends Mapper
{
    function __construct()
    {
        $db = \Base::instance()->get("DB");

        parent::__construct($db, DBView::MATCH_SET_IMAGES->value);
    }
}
