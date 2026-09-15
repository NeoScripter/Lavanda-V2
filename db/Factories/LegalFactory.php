<?php

declare(strict_types=1);

namespace Factories;

use Http\Models\Legal;

class LegalFactory extends Factory
{
    public function create(array $attrs)
    {
        $legal = new Legal();
        $legal->copyfrom($attrs);
        $legal->html = $attrs['html'] ?? $this->faker->sentences(20, true);
        $legal->save();

        return $legal;
    }
}
