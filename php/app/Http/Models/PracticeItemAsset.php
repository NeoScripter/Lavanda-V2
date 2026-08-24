<?php

namespace Http\Models;

use DB\SQL\Mapper;
use Enums\DBView;

class PracticeItemAsset extends Mapper
{
    function __construct()
    {
        $db = \Base::instance()->get("DB");

        parent::__construct($db, DBView::PRACTICE_ITEM_ASSET->value);
    }

    function to_resource(): array
    {
        return [
            ...$this->cast(),
            'image' => [
                'id' => $this->image_id,
                'src' => $this->image_src,
                'alt' => $this->image_alt,
            ]
        ];
    }
}
