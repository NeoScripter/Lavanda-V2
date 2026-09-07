<?php

declare(strict_types=1);

namespace Factories;

use Enums\ImageableType;
use Http\Models\Article;

class ArticleFactory extends Factory
{
    public function create(array $attrs, string $img_src)
    {
        $article = new Article();
        $article->copyfrom($attrs);
        $article->save();

        $img_attrs = [
            'imageable_type' => ImageableType::ARTICLE->value,
            'imageable_id' => $article->id,
        ];

        (new ImageFactory)->create(
            attrs: array_merge($img_attrs, ['variant' => 'preview']),
            src_dir: $img_src
        );
        (new ImageFactory)->create(
            attrs: array_merge($img_attrs, ['variant' => 'image']),
            src_dir: APP_DIR . '/public/assets/images/shared/empty/'
        );

        return $article;
    }
}
