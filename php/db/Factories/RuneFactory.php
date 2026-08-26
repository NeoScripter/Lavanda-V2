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

        (new ImageFactory)->create(dir: 'test', imageable_type: $imageable_type, imageable_id: $rune->id, variant: 'front_image');
        (new ImageFactory(variant: 'back_image'))->create(dir: 'test', imageable_type: $imageable_type, imageable_id: $rune->id, variant: 'back_image');

        return $rune;
    }
}
