<?php

declare(strict_types=1);

namespace Factories;

use Enums\ImageableType;
use Http\Models\Rune;

class RuneFactory extends Factory
{
    public function create(array $attrs, string $front_img_src, string $back_img_src)
    {
        $rune = new Rune();
        $rune->copyfrom($attrs);
        $rune->save();

        $img_attrs = [
            'imageable_type' => ImageableType::RUNE->value,
            'imageable_id' => $rune->id,
        ];

        (new ImageFactory)->create(
            attrs: array_merge($img_attrs, ['variant' => 'front_image']),
            src_dir: $front_img_src
        );
        (new ImageFactory)->create(
            attrs: array_merge($img_attrs, ['variant' => 'back_image']),
            src_dir: $back_img_src
        );

        return $rune;
    }
}
