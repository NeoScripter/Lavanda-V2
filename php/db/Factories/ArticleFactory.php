<?php

declare(strict_types=1);

namespace Factories;

use Enums\ImageableType;
use Http\Models\Article;

class ArticleFactory extends Factory
{
    public function create(?array $attrs = [])
    {
        $article = new Article();

        $article->description = $attrs['description'] ?? $this->faker->sentences(20, true);
        $article->html = $attrs['html'] ?? file_get_contents(APP_DIR . '/db/Fixtures/Card/html.md');
        $article->save();

        $imageable_type = ImageableType::ARTICLE;

        (new ImageFactory)->create(
            dir: 'article',
            imageable_type: $imageable_type->value,
            imageable_id: $article->id,
            variant: 'preview'
        );

        (new ImageFactory)->create(
            dir: 'article',
            imageable_type: $imageable_type->value,
            imageable_id: $article->id,
            variant: 'image'
        );

        return $article;
    }
}
