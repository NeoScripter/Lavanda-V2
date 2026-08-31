<?php

declare(strict_types=1);

namespace Factories;

use Http\Models\Affirmation;

class AffirmationFactory extends Factory
{
    public function create(?array $attrs = [])
    {
        $affirmation = new Affirmation();

        $affirmation->topic = $attrs['topic'] ?? $this->faker->word();
        $affirmation->quote = $attrs['quote'] ??  $this->faker->sentences(3, true);

        $affirmation->save();

        return $affirmation;
    }
}
