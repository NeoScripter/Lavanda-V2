<?php

declare(strict_types=1);

namespace Factories;

use Enums\CardVariant;
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

        (new ImageFactory)->create(dir: 'test', imageable_type: $card->variant, imageable_id: $card->id, variant: 'front');

        if ($with_back) {
            (new ImageFactory(variant: 'back'))->create(dir: 'test', imageable_type: $card->variant, imageable_id: 1, variant: 'back');
        }

        return $card;
    }
}
