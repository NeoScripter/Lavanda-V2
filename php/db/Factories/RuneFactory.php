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
}
