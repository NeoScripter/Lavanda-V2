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
        $theme->html = $attrs['html'] ?? file_get_contents(APP_DIR . '/db/Fixtures/Card/html.md');
        $theme->save();

        return $theme;
    }
}
