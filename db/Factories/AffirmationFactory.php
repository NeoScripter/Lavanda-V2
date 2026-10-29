<?php

declare(strict_types=1);

namespace Factories;

use Enums\Locale;
use Http\Models\Affirmation;

class AffirmationFactory extends Factory
{
    public function create(?array $attrs = [])
    {
        $affirmation = new Affirmation();

        $affirmation->topic = $attrs['topic'] ?? $this->faker->sentence();
        $affirmation->quote = $attrs['quote'] ??  $this->faker->sentences(3, true);
        $affirmation->locale = $attrs['locale'] ?? Locale::RUSSIAN->value;

        $affirmation->save();

        return $affirmation;
    }

    public function seed(array $attrs)
    {
        $affirmation = new Affirmation();
        $affirmation->copyfrom($attrs);
        $affirmation->save();

        return $affirmation;
    }
}
