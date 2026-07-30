<?php

declare(strict_types=1);

namespace Factories;

use Enums\CardVariant;
use Http\Models\Card;

class CardFactory extends Factory
{
    public function create()
    {
        $card = new Card();

        $card->name = $this->faker->word();
        $card->advice = $this->faker->sentence();

        $card->html = \Markdown::instance()->convert(file_get_contents(APP_DIR . '/db/Fixtures/Card/html.md'));
        $card->variant = CardVariant::METAPHORIC->value;
        $card->save();

        (new ImageFactory)->create(dir: 'test', imageable_type: $card->variant, imageable_id: $card->id, variant: 'front');

        return $card;
    }
}
