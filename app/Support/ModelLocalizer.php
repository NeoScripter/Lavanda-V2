<?php

declare(strict_types=1);

namespace Support;

use Enums\ClonableType;
use Enums\Locale;
use Factories\ImageFactory;
use Http\Models\Card;
use Http\Models\Rune;
use Http\Models\Theme;
use Log;

final class ModelLocalizer
{
    public function __construct(private ClonableType $category, private Locale $locale) {}

    public function clone_all(): void
    {
        switch ($this->category) {
            case ClonableType::TAROT:
            case ClonableType::BONUS:
            case ClonableType::LENORMAND:
            case ClonableType::MIND_GAMES:
            case ClonableType::MINORI:
            case ClonableType::METAPHORIC:
                $this->clone_cards();
                break;
            case ClonableType::RUNE:
                $this->clone_runes();
                break;
            case ClonableType::DICE:
                $this->clone_dices();
                break;
            case ClonableType::STONE:
                $this->clone_stones();
                break;
            case ClonableType::FAQ:
                $this->clone_faqs();
                break;
            case ClonableType::ICHING:
                $this->clone_ichings();
                break;
            case ClonableType::AFFIRMATION:
                $this->clone_affirmations();
                break;
            case ClonableType::ARTICLE:
                $this->clone_articles();
                break;
        }
    }

    private function clone_stones() {}
    private function clone_dices() {}
    private function clone_faqs() {}
    private function clone_ichings() {}
    private function clone_affirmations() {}
    private function clone_articles() {}

    private function clone_runes()
    {
        $db = \Base::instance()->get("DB");

        $rows = $db->exec("SELECT count(id) FROM runes WHERE locale = ?", [$this->locale->value]);

        if (! empty($rows[0]['count']) && $rows[0]['count'] > 0) {
            $logger = new Log('error.log');
            $logger->write("Error cloning the runes: the runes for this locale are already seeded {$this->locale->value}");
            return;
        }

        $runes = new Rune();
        $runes = $runes->find(['locale = ?', Locale::RUSSIAN->value]);

        $new_rune = new Rune();

        if (empty($runes)) return;

        foreach ($runes as $rune) {
            $front_img = $rune->front_image;
            $back_img = $rune->back_image;

            $themes = $rune->themes;

            $new_rune->copyfrom([
                'name' => $rune->name,
                'variant' => $rune->variant,
                'advice' => $rune->advice,
                'locale' => $this->locale->value,
            ]);

            $new_rune->save();

            foreach ($themes as $theme) {
                $new_theme = new Theme();
                $new_theme->copyfrom([
                    'html' => $theme->html,
                    'name' => $theme->name,
                    'themeable_type' => $theme->themeable_type,
                    'themeable_id' => $new_rune->id,
                ]);
                $new_theme->save();
            }

            $img_factory = new ImageFactory();
            $img_factory->create(
                attrs: [
                    'imageable_type' => $front_img->imageable_type,
                    'imageable_id' => $new_rune->id,
                    'variant' => $front_img->variant,
                    'alt' => $front_img->alt,
                ],
                src_dir: to_absolute_path(get_parent_dir($front_img->src))
            );
            $img_factory->create(
                attrs: [
                    'imageable_type' => $back_img->imageable_type,
                    'imageable_id' => $new_rune->id,
                    'variant' => $back_img->variant,
                    'alt' => $back_img->alt,
                ],
                src_dir: to_absolute_path(get_parent_dir($back_img->src))
            );
            $new_rune->reset();
        }
    }

    private function clone_cards()
    {
        $db = \Base::instance()->get("DB");

        $rows = $db->exec("SELECT count(id) FROM cards WHERE locale = ?", [$this->locale->value]);

        if (! empty($rows[0]['count']) && $rows[0]['count'] > 0) {
            $logger = new Log('error.log');
            $logger->write("Error cloning the cards: the cards for this locale are already seeded {$this->locale->value}");
            return;
        }

        $cards = new Card();
        $cards = $cards->find(['locale = ? AND variant = ?', Locale::RUSSIAN->value, $this->category->value]);

        $new_card = new Card();

        if (empty($cards)) return;

        foreach ($cards as $card) {
            $front_img = $card->front_image;

            $themes = $card->themes;

            $new_card->copyfrom([
                'name' => $card->name,
                'description' => $card->description,
                'variant' => $card->variant,
                'advice' => $card->advice,
                'locale' => $this->locale->value,
            ]);

            $new_card->save();

            foreach ($themes as $theme) {
                $new_theme = new Theme();
                $new_theme->copyfrom([
                    'html' => $theme->html,
                    'name' => $theme->name,
                    'themeable_type' => $theme->themeable_type,
                    'themeable_id' => $new_card->id,
                ]);
                $new_theme->save();
            }

            $img_factory = new ImageFactory();
            $img_factory->create(
                attrs: [
                    'imageable_type' => $front_img->imageable_type,
                    'imageable_id' => $new_card->id,
                    'variant' => $front_img->variant,
                    'alt' => $front_img->alt,
                ],
                src_dir: to_absolute_path(get_parent_dir($front_img->src))
            );
            $new_card->reset();
        }
    }
}
