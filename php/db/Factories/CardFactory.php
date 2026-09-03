<?php

declare(strict_types=1);

namespace Factories;

use Enums\CardVariant;
use Enums\ImageableType;
use Http\Models\Card;

class CardFactory extends Factory
{
    public function create(?array $attrs = [], ?bool $with_back = false)
    {
        $card = new Card();

        $card->name = $attrs['name'] ?? $this->faker->word();
        $card->advice = $attrs['advice'] ??  $this->faker->sentence();

        $card->description = $attrs['description'] ?? $this->faker->sentences(20, true);
        $card->variant = $attrs['variant'] ?? CardVariant::METAPHORIC->value;
        $card->save();

        $imageable_type = ImageableType::from($card->variant);

        (new ImageFactory)->create(
            attrs: ['imageable_type' => $imageable_type, 'imageable_id' => $card->id, 'variant' => 'front_image'],
            src_dir: APP_DIR . '/db/Fixtures/Image/front_image/',
        );

        if ($with_back) {
            (new ImageFactory)->create(
                attrs: ['imageable_type' => $imageable_type, 'imageable_id' => $card->id, 'variant' => 'back_image'],
                src_dir: APP_DIR . '/db/Fixtures/Image/back_image/',
            );
        }

        return $card;
    }
}
