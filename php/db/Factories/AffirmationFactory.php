<?php

declare(strict_types=1);

namespace Factories;

use Http\Models\Affirmation;

class AffirmationFactory extends Factory
{
    public function create(array $attrs)
    {
        $affirmation = new Affirmation();
        $affirmation->copyfrom($attrs);
        $affirmation->save();

        return $affirmation;
    }
}
