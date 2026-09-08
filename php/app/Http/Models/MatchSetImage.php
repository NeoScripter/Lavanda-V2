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

    function to_resource(): array
    {
        return [
            ...$this->cast(),
            'images' => json_decode(
                html_entity_decode($this['images'], ENT_QUOTES),
                true
            )
        ];
    }
}
