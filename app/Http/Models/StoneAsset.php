<?php

namespace Http\Models;

use DB\SQL\Mapper;
use Enums\DBView;

class StoneAsset extends Mapper
{
    function __construct()
    {
        $db = \Base::instance()->get("DB");

        parent::__construct($db, DBView::STONE_ASSET->value);
    }

    function to_resource(): array
    {
        return [
            ...$this->cast(),
            'preview' => [
                'id' => $this->preview_id,
                'src' => $this->preview_src,
                'alt' => $this->preview_alt,
            ],
            'image' => [
                'id' => $this->image_id,
                'src' => $this->image_src,
                'alt' => $this->image_alt,
            ]
        ];
    }
}
