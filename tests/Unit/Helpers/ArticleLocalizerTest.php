<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use DB\SQL;
use Enums\ClonableType;
use Enums\Locale;
use Factories\ArticleFactory;
use Http\Models\Article;
use PHPUnit\Framework\Attributes\Test;
use Support\ModelLocalizer;
use Tests\TestCase;

final class ArticleLocalizerTest extends TestCase
{
    protected null|SQL $db;

    protected function setUp(): void
    {
        parent::setUp();
        $this->db = \Base::instance()->get('DB');
    }

    #[Test]
    public function clones_articles_to_another_locale_with_submodels(): void
    {
        $cloneable_type = ClonableType::ARTICLE->value;
        $factory = new ArticleFactory();

        for ($i = 0; $i < 5; $i++) {
            $factory->create(attrs: [
                'locale' => Locale::RUSSIAN->value
            ]);
        }

        $q = "SELECT count(id) FROM articles";
        $prev_count = $this->db->exec($q)[0]['count'];

        $cloner = new ModelLocalizer(ClonableType::ARTICLE, Locale::ENGLISH);
        $cloner->clone_all();

        $new_count = $this->db->exec($q)[0]['count'];
        $all_variants_count = $this->db->exec("SELECT count(id) FROM articles")[0]['count'];

        $this->assertEquals(expected: $prev_count * 2, actual: $new_count);
        $this->assertEquals(expected: $all_variants_count, actual: $new_count);

        $front_img_count =  $this->db->exec(
            "SELECT count(id) FROM images WHERE imageable_type = ? AND variant = 'preview'",
            $cloneable_type
        )[0]['count'];

        $back_img_count =  $this->db->exec(
            "SELECT count(id) FROM images WHERE imageable_type = ? AND variant = 'image'",
            $cloneable_type
        )[0]['count'];

        $this->assertEquals(expected: $new_count, actual: $back_img_count);
        $this->assertEquals(expected: $new_count, actual: $front_img_count);

        $articles = new Article();
        $articles->find();

        foreach ($articles as $article) {
            $article->erase();
        }
    }

    #[Test]
    public function doesnt_clone_article_when_already_present(): void
    {
        $factory = new ArticleFactory();

        for ($i = 0; $i < 5; $i++) {
            $factory->create(attrs: ['locale' => Locale::RUSSIAN->value]);
        }

        $factory->create(attrs: ['locale' => Locale::ENGLISH->value]);

        $q = "SELECT count(id) FROM articles";
        $prev_count = $this->db->exec($q)[0]['count'];

        $cloner = new ModelLocalizer(ClonableType::ARTICLE, Locale::ENGLISH);
        $cloner->clone_all();

        $new_count = $this->db->exec($q)[0]['count'];

        $this->assertEquals(expected: $prev_count, actual: $new_count);

        $articles = new Article();
        $articles->find();

        foreach ($articles as $article) {
            $article->erase();
        }
    }
}
