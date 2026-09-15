<?php

declare(strict_types=1);

namespace Factories;

use Http\Models\Theme;

class ThemeFactory extends Factory
{
    public function create(array $attrs)
    {
        $theme = new Theme();
        $theme->copyfrom($attrs);
        $theme->html = $attrs['html'] ?? $this->faker->sentences(20, true);
        $theme->save();

        return $theme;
    }
}
