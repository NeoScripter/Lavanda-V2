<?php

declare(strict_types=1);

namespace Factories;

use Enums\ImageableType;
use Http\Models\Stone;

class StoneFactory extends Factory
{
    public function create(?array $attrs = [])
    {
        $stone = new Stone();

        $stone->name = $attrs['name'] ?? $this->faker->word();
        $stone->advice = $attrs['advice'] ??  $this->faker->sentence();
        $stone->save();

        $img_attrs = [
            'imageable_type' => ImageableType::STONE->value,
            'imageable_id' => $stone->id,
        ];

        $img_src = APP_DIR . '/db/Fixtures/Image/front_image/';

        (new ImageFactory)->create(
            attrs: [...$img_attrs, 'variant' => 'preview'],
            src_dir: $img_src
        );
        (new ImageFactory)->create(
            attrs: [...$img_attrs, 'variant' => 'image'],
            src_dir: $img_src
        );

        return $stone;
    }

    public function seed(array $attrs, string $preview_src, string $image_src)
    {
        $stone = new Stone();
        $stone->copyfrom($attrs);
        $stone->save();

        $img_attrs = [
            'imageable_type' => ImageableType::STONE->value,
            'imageable_id' => $stone->id,
        ];

        (new ImageFactory)->create(
            attrs: array_merge($img_attrs, ['variant' => 'preview']),
            src_dir: $preview_src
        );
        (new ImageFactory)->create(
            attrs: array_merge($img_attrs, ['variant' => 'image']),
            src_dir: $image_src
        );

        return $stone;
    }
}
