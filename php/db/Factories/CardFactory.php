<?php

declare(strict_types=1);

namespace Factories;

use Http\Models\Card;

class CardFactory extends Factory
{
    public function create(array $attrs, string $img_src)
    {
        $card = new Card();
        $card->copyfrom($attrs);
        $card->save();

        $img_attrs = [
            'imageable_type' => $attrs['variant'],
            'imageable_id' => $card->id,
        ];

        (new ImageFactory)->create(
            attrs: array_merge($img_attrs, ['variant' => 'front_image']),
            src_dir: $img_src
        );

        return $card;
    }
}
