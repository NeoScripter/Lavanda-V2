<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use Enums\ThemeableType;
use Factories\CardFactory;
use Factories\ThemeFactory;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class HelpersTest extends TestCase
{

    #[Test]
    public function returns_unique_themes_grouped_by_type(): void
    {
        $cardF = new CardFactory();
        $themeF = new ThemeFactory();

        $extra_themes = ['Apple', 'Career'];
        $one_theme_card = $cardF->create();

        $one_theme_id = $one_theme_card->themes[0]->id;

        $this->assertNotEmpty($one_theme_id);

        for ($i = 0; $i < 12; $i++) {
            $card = $cardF->create();

            foreach ($extra_themes as $theme_name) {
                $themeF->create([
                    'name' => $theme_name,
                    'themeable_id' => $card->id,
                    'themeable_type' => $card->variant,
                ]);
            }
        }

        $unique_themes = get_unique_themes_by_type(
            themeable_type: ThemeableType::from($one_theme_card->variant),
            themeable_id: $one_theme_card->id
        );

        $expected = [
            ['name' => 'Apple'],
            ['name' => 'Career'],
            ['name' => 'Общая', 'model_id' => $one_theme_card->id, 'theme_id' => $one_theme_id],
        ];

        $this->assertArraysAreEqual(expected: $expected, actual: $unique_themes);
    }
}
