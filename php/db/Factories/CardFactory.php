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

        $card->html = $attrs['html'] ?? file_get_contents(APP_DIR . '/db/Fixtures/Card/html.md');
        $card->variant = $attrs['variant'] ?? CardVariant::METAPHORIC->value;
        $card->save();

        $imageable_type = ImageableType::from($card->variant);

        (new ImageFactory)->create(
            dir: 'test',
            imageable_type: $imageable_type->value,
            imageable_id: $card->id,
            variant: 'front_image'
        );

        if ($with_back) {
            (new ImageFactory(variant: 'back_image'))->create(
                dir: 'test',
                imageable_type: $imageable_type->value,
                imageable_id: 1,
                variant: 'back_image'
            );
        }

        return $card;
    }
}
