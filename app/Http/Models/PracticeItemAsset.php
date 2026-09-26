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
            'faqs' => json_decode(
                html_entity_decode($this->faqs),
                true
            ),
            'image' => [
                'id' => $this->image_id,
                'src' => $this->image_src,
                'alt' => $this->image_alt,
            ]
        ];
    }

    function to_item(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'file' => $this->file,
            'faqs' => html_entity_decode($this->faqs),
            'img_alt' => $this->image_alt,
            'img_src' => $this->image_src,
        ];
    }
}
