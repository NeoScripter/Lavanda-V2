<?php

declare(strict_types=1);

namespace Factories;

use Enums\ImageableType;
use Enums\RuneTheme as RuneThemeEnum;
use Http\Models\Rune;
use Http\Models\RuneTheme;

class RuneFactory extends Factory
{
    public function create(?array $attrs = [])
    {
        $rune = new Rune();

        $rune->name = $attrs['name'] ?? $this->faker->word();
        $rune->advice = $attrs['advice'] ??  $this->faker->sentence();
        $html = $attrs['html'] ?? file_get_contents(APP_DIR . '/db/Fixtures/Rune/html.md');
        $rune->save();

        foreach (RuneThemeEnum::values() as $name) {
            $theme = new RuneTheme();
            $theme->name = $name;
            $theme->html = $name . "\n\n" . $html;
            $theme->rune = $rune;
            $theme->save();
        }

        $imageable_type = ImageableType::RUNE->value;

        (new ImageFactory)->create(dir: 'test', imageable_type: $imageable_type, imageable_id: $rune->id, variant: 'front_image');
        (new ImageFactory(variant: 'back_image'))->create(dir: 'test', imageable_type: $imageable_type, imageable_id: $rune->id, variant: 'back_image');

        return $rune;
    }
}
