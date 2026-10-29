<?php

declare(strict_types=1);

namespace Support;

use Enums\ClonableType;
use Enums\Locale;
use Factories\ImageFactory;
use Http\Models\Affirmation;
use Http\Models\Article;
use Http\Models\Card;
use Http\Models\FAQ;
use Http\Models\Iching;
use Http\Models\PracticeItem;
use Http\Models\Rune;
use Http\Models\Stone;
use Http\Models\Theme;

final class ModelLocalizer
{
    public function __construct(private ClonableType $category, private Locale $locale) {}

    public function clone_all(): string
    {
        switch ($this->category) {
            case ClonableType::TAROT:
            case ClonableType::BONUS:
            case ClonableType::LENORMAND:
            case ClonableType::MIND_GAMES:
            case ClonableType::MINORI:
            case ClonableType::METAPHORIC:
                return $this->clone_cards();
            case ClonableType::RUNE:
                return $this->clone_runes();
            case ClonableType::STONE:
                return $this->clone_stones();
            case ClonableType::FAQ:
                return $this->clone_faqs();
            case ClonableType::PRACTICE_ITEM:
                return $this->clone_practice_items();
            case ClonableType::ICHING:
                return $this->clone_ichings();
            case ClonableType::AFFIRMATION:
                return $this->clone_affirmations();
            case ClonableType::ARTICLE:
                return $this->clone_articles();
            default: return '';
        }
    }

    private function clone_articles()
    {
        $db = \Base::instance()->get("DB");

        $rows = $db->exec("SELECT count(id) FROM articles WHERE locale = ?", [$this->locale->value]);

        if (! empty($rows[0]['count']) && $rows[0]['count'] > 0) {
            return "Error cloning the articles: the articles for this locale are already seeded {$this->locale->value}";
        }

        $articles = new Article();
        $articles = $articles->find(['locale = ?', Locale::RUSSIAN->value]);

        $new_article = new Article();

        if (empty($articles)) {
            return "Error cloning the articles: the articles for Russian locale are empty";
        }

        foreach ($articles as $article) {
            $front_img = $article->preview;
            $back_img = $article->image;

            $new_article->copyfrom([
                'name' => $article->name,
                'description' => $article->description,
                'html' => $article->html,
                'locale' => $this->locale->value,
            ]);

            $new_article->save();

            $img_factory = new ImageFactory();
            $img_factory->create(
                attrs: [
                    'imageable_type' => $front_img->imageable_type,
                    'imageable_id' => $new_article->id,
                    'variant' => $front_img->variant,
                    'alt' => $front_img->alt,
                ],
                src_dir: to_absolute_path(get_parent_dir($front_img->src))
            );
            $img_factory->create(
                attrs: [
                    'imageable_type' => $back_img->imageable_type,
                    'imageable_id' => $new_article->id,
                    'variant' => $back_img->variant,
                    'alt' => $back_img->alt,
                ],
                src_dir: to_absolute_path(get_parent_dir($back_img->src))
            );
            $new_article->reset();
        }

        return "Articles successfully cloned!";
    }

    private function clone_affirmations()
    {
        $db = \Base::instance()->get("DB");

        $rows = $db->exec("SELECT count(id) FROM affirmations WHERE locale = ?", [$this->locale->value]);

        if (! empty($rows[0]['count']) && $rows[0]['count'] > 0) {
            return "Error cloning the affirmations: the affirmations for this locale are already seeded {$this->locale->value}";
        }

        $affirmations = new Affirmation();
        $affirmations = $affirmations->find(['locale = ?', Locale::RUSSIAN->value]);

        $new_affirmation = new Affirmation();

        if (empty($affirmations)) {
            return "Error cloning the affirmations: the affirmations for Russian locale are empty";
        }

        foreach ($affirmations as $affirmation) {

            $new_affirmation->copyfrom([
                'quote' => $affirmation->quote,
                'topic' => $affirmation->topic,
                'locale' => $this->locale->value,
            ]);

            $new_affirmation->save();
            $new_affirmation->reset();
        }

        return "Affirmations successfully cloned!";
    }


    private function clone_practice_items()
    {
        $db = \Base::instance()->get("DB");

        $rows = $db->exec("SELECT count(id) FROM practice_items WHERE locale = ?", [$this->locale->value]);

        if (! empty($rows[0]['count']) && $rows[0]['count'] > 0) {
            return "Error cloning the practice_items: the practice_items for this locale are already seeded {$this->locale->value}";
        }

        $items = new PracticeItem();
        $items = $items->find(['locale = ?', Locale::RUSSIAN->value]);

        $new_item = new PracticeItem();

        if (empty($items)) {
            return "Error cloning the items: the items for Russian locale are empty";
        }

        foreach ($items as $item) {
            $front_img = $item->image;

            $new_item->copyfrom([
                'title' => $item->title,
                'abstract' => $item->abstract,
                'file' => 'example',
                'description' => $item->description,
                'faqs' => $item->faqs,
                'locale' => $this->locale->value,
            ]);

            $new_item->save();

            $img_factory = new ImageFactory();
            $img_factory->create(
                attrs: [
                    'imageable_type' => $front_img->imageable_type,
                    'imageable_id' => $new_item->id,
                    'variant' => $front_img->variant,
                    'alt' => $front_img->alt,
                ],
                src_dir: to_absolute_path(get_parent_dir($front_img->src))
            );
            $new_item->reset();
        }

        return "Practice Items successfully cloned!";
    }

    private function clone_ichings()
    {
        $db = \Base::instance()->get("DB");

        $rows = $db->exec("SELECT count(id) FROM ichings WHERE locale = ?", [$this->locale->value]);

        if (! empty($rows[0]['count']) && $rows[0]['count'] > 0) {
            return "Error cloning the ichings: the ichings for this locale are already seeded {$this->locale->value}";
        }

        $ichings = new Iching();
        $ichings = $ichings->find(['locale = ?', Locale::RUSSIAN->value]);

        $new_iching = new Iching();

        if (empty($ichings)) {
            return "Error cloning the ichings: the ichings for Russian locale are empty";
        }

        foreach ($ichings as $iching) {

            $new_iching->copyfrom([
                'bitmask' => $iching->bitmask,
                'number' => $iching->number,
                'description' => $iching->description,
                'locale' => $this->locale->value,
            ]);

            $new_iching->save();
            $new_iching->reset();
        }

        return "Ichings successfully cloned!";
    }


    private function clone_stones()
    {
        $db = \Base::instance()->get("DB");

        $rows = $db->exec("SELECT count(id) FROM stones WHERE locale = ?", [$this->locale->value]);

        if (! empty($rows[0]['count']) && $rows[0]['count'] > 0) {
            return "Error cloning the stones: the stones for this locale are already seeded {$this->locale->value}";
        }

        $stones = new Stone();
        $stones = $stones->find(['locale = ?', Locale::RUSSIAN->value]);

        $new_stone = new Stone();

        if (empty($stones)) {
            return "Error cloning the stones: the stones for Russian locale are empty";
        }

        foreach ($stones as $stone) {
            $front_img = $stone->preview;
            $back_img = $stone->image;

            $new_stone->copyfrom([
                'name' => $stone->name,
                'variant' => $stone->variant,
                'html' => $stone->html,
                'locale' => $this->locale->value,
            ]);

            $new_stone->save();

            $img_factory = new ImageFactory();
            $img_factory->create(
                attrs: [
                    'imageable_type' => $front_img->imageable_type,
                    'imageable_id' => $new_stone->id,
                    'variant' => $front_img->variant,
                    'alt' => $front_img->alt,
                ],
                src_dir: to_absolute_path(get_parent_dir($front_img->src))
            );
            $img_factory->create(
                attrs: [
                    'imageable_type' => $back_img->imageable_type,
                    'imageable_id' => $new_stone->id,
                    'variant' => $back_img->variant,
                    'alt' => $back_img->alt,
                ],
                src_dir: to_absolute_path(get_parent_dir($back_img->src))
            );
            $new_stone->reset();
        }

        return "Stones successfully cloned!";
    }

    private function clone_faqs()
    {
        $db = \Base::instance()->get("DB");

        $rows = $db->exec("SELECT count(id) FROM faqs WHERE locale = ?", [$this->locale->value]);

        if (! empty($rows[0]['count']) && $rows[0]['count'] > 0) {
            return "Error cloning the faqs: the faqs for this locale are already seeded {$this->locale->value}";
        }

        $faqs = new FAQ();
        $faqs = $faqs->find(['locale = ?', Locale::RUSSIAN->value]);

        $new_faq = new FAQ();

        if (empty($faqs)) {
            return "Error cloning the faqs: the faqs for Russian locale are empty";
        }

        foreach ($faqs as $faq) {

            $new_faq->copyfrom([
                'answer' => $faq->answer,
                'question' => $faq->question,
                'locale' => $this->locale->value,
            ]);

            $new_faq->save();
            $new_faq->reset();
        }

        return "FAQs successfully cloned!";
    }

    private function clone_runes()
    {
        $db = \Base::instance()->get("DB");

        $rows = $db->exec("SELECT count(id) FROM runes WHERE locale = ?", [$this->locale->value]);

        if (! empty($rows[0]['count']) && $rows[0]['count'] > 0) {
            return "Error cloning the runes: the runes for this locale are already seeded {$this->locale->value}";
        }

        $runes = new Rune();
        $runes = $runes->find(['locale = ?', Locale::RUSSIAN->value]);

        $new_rune = new Rune();

        if (empty($runes)) {
            return "Error cloning the runes: the runes for Russian locale are empty";
        }

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

        return "Runes successfully cloned!";
    }

    private function clone_cards()
    {
        $db = \Base::instance()->get("DB");

        $rows = $db->exec("SELECT count(id) FROM cards WHERE locale = ?", [$this->locale->value]);

        if (! empty($rows[0]['count']) && $rows[0]['count'] > 0) {
            return "Error cloning the cards: the cards for this locale are already seeded {$this->locale->value}";
        }

        $cards = new Card();
        $cards = $cards->find(['locale = ? AND variant = ?', Locale::RUSSIAN->value, $this->category->value]);

        $new_card = new Card();

        if (empty($cards)) {
            return "Error cloning the cards: the cards for Russian locale are empty";
        }

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

        return "Cards successfully cloned!";
    }
}
