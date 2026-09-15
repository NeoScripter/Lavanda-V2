<?php

namespace Http\Models;

use DB\SQL\Mapper;
use Enums\DBView;

class RuneAsset extends Mapper
{
    function __construct()
    {
        $db = \Base::instance()->get("DB");

        parent::__construct($db, DBView::RUNE_ASSET->value);
    }

    function to_resource(): array
    {
        return [
            ...$this->cast(),
            'front_image' => [
                'id' => $this->front_id,
                'src' => $this->front_src,
                'alt' => $this->front_alt,
            ],
            'back_image' => [
                'id' => $this->back_id,
                'src' => $this->back_src,
                'alt' => $this->back_alt,
            ]
        ];
    }
}
