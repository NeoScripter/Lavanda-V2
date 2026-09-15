<?php

declare(strict_types=1);

namespace Factories;

use Enums\ImageableType;
use Http\Models\Rune;

class RuneFactory extends Factory
{
    public function create(?array $attrs = [])
    {
        $rune = new Rune();

        $rune->name = $attrs['name'] ?? $this->faker->word();
        $rune->advice = $attrs['advice'] ??  $this->faker->sentence();
        $rune->save();

        $imageable_type = ImageableType::RUNE->value;

        (new ImageFactory)->create(
            attrs: ['imageable_type' => $imageable_type, 'imageable_id' => $rune->id, 'variant' => 'front_image'],
            src_dir: APP_DIR . '/db/Fixtures/Image/front_image/',
        );
        (new ImageFactory)->create(
            attrs: ['imageable_type' => $imageable_type, 'imageable_id' => $rune->id, 'variant' => 'back_image'],
            src_dir: APP_DIR . '/db/Fixtures/Image/back_image/',
        );

        return $rune;
    }

    public function seed(array $attrs, string $front_img_src, string $back_img_src)
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
