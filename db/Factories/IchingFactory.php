<?php

declare(strict_types=1);

namespace Factories;

use Http\Models\Iching;

class IchingFactory extends Factory
{
    public function create(?array $attrs = [])
    {
        $iching = new Iching();

        $iching->description = $attrs['description'] ?? $this->faker->sentences(25, true);
        $iching->number = $attrs['number'];
        $iching->bitmask = $attrs['bitmask'];

        $iching->save();

        return $iching;
    }

    public function seed(array $attrs)
    {
        $iching = new Iching();

        $iching->number = (int) $attrs['number'];
        $iching->bitmask = (int) $attrs['bitmask'];
        $iching->description = $attrs['description'];
        $iching->save();

        return $iching;
    }
}
