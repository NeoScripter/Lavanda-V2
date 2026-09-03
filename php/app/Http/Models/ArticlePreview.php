<?php

namespace Http\Models;

use DB\SQL\Mapper;
use Enums\DBView;

class ArticlePreview extends Mapper
{
    function __construct()
    {
        $db = \Base::instance()->get("DB");

        parent::__construct($db, DBView::ARTICLE_PREVIEW->value);
    }

    function to_resource(): array
    {
        return [
            ...$this->cast(),
            'preview' => [
                'id' => $this->preview_id,
                'src' => $this->preview_src,
                'alt' => $this->preview_alt,
            ]
        ];
    }
}
