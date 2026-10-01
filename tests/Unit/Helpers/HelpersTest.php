<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use Enums\ThemeableType;
use Factories\CardFactory;
use Factories\ThemeFactory;
use PHPUnit\Framework\Attributes\DataProvider;
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

    #[Test]
    #[DataProvider('tw_classes')]
    public function correctly_merges_and_sorts_tw_classes(string $base, string $merged, string $expected): void
    {
        $this->assertEquals(expected: $expected, actual: cc(base: $base, merged: $merged));
    }

    public static function tw_classes(): array
    {
        return [
            [
                'base' => 'pt-23 text-red-400 px-10 xl:mx-20',
                'merged' => 'pt-13 px-20 xl:mx-10',
                'expected' => 'pt-13 px-20 text-red-400 xl:mx-10',
            ],
            [
                'base' => 'px-20 lg:px-30 xl:px-40 2xl:px-40 m-10 lg:m-20',
                'merged' => 'px-5 lg:px-10 xl:px-15 2xl:px-20',
                'expected' => '2xl:px-20 lg:m-20 lg:px-10 m-10 px-5 xl:px-15',
            ],
            [
                'base' => 'pt-(--pt-lg) px-4 sm:px-18 rounded-primary pb-19 sm:pb-38 shadow-accent relative isolate lg:pb-31 xl:pb-48 xl:px-45 full-bleed sm:w-[calc(100%-var(--px-sm)*2)]! mx-auto bg-no-repeat',
                'merged' => '',
                'expected' => 'pt-(--pt-lg) px-4 sm:px-18 rounded-primary pb-19 sm:pb-38 shadow-accent relative isolate lg:pb-31 xl:pb-48 xl:px-45 full-bleed sm:w-[calc(100%-var(--px-sm)*2)]! mx-auto bg-no-repeat'
            ]
        ];
    }
}
