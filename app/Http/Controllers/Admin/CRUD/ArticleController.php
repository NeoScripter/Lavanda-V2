<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Enums\ImageableType;
use Enums\Locale;
use Enums\SessionKey;
use Exception;
use Http\Controller;
use Http\Models\Article;
use Http\Models\ArticlePreview;
use Http\Requests\CRUD\Article\StoreArticleRequest;
use Http\Requests\CRUD\Article\UpdateArticleRequest;
use Traits\RequiresAuth;

class ArticleController extends Controller
{
    use RequiresAuth;

    private $preview_sizes = ['mb' => 150, 'tb' => 200, 'dk' => 250];
    private $image_sizes = ['mb' => 550, 'tb' => 800, 'dk' => 1400];

    public function index(\Base $hive)
    {
        $page = $hive->GET['page'] ?? 1;
        $page = is_numeric($page) ? (int) $page : 1;
        $locale = Locale::normalize($hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value) ?? '');

        $articles = new ArticlePreview();
        $articles = $articles->paginate(
            $page - 1,
            15,
            ['locale=?', $locale],
            ['order' => 'created_at DESC']
        );

        view('pages/admin/articles/index', [
            'title' => 'All articles',
            'articles' => $articles,
        ]);
    }

    public function create()
    {
        view('pages/admin/articles/create');
    }

    public function edit(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $article = new Article();
        $article->load(['id = ?', $id]);

        view('pages/admin/articles/edit', [
            'title' => $hive->get('admin.article'),
            'article' => $article,
        ]);
    }

    public function show(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $article = new Article();
        $article->load(['id = ?', $id]);

        view('pages/admin/articles/show', [
            'title' => $hive->get('admin.article'),
            'article' => $article,
        ]);
    }

    public function store(\Base $hive)
    {
        $request = $this->request(StoreArticleRequest::class);
        $request->validate();

        $article = new Article();
        $article->copyFrom($request->all());
        $article->save();

        if (! $article->dry() && !empty($request->input('image'))) {
            attach_image_to_model(
                model: $article,
                imageable_type: $article->variant,
                variant: 'image',
                file: $request->input('image')[0],
                sizes: $this->image_sizes
            );
        }

        if (! $article->dry() && !empty($request->input('preview'))) {
            attach_image_to_model(
                model: $article,
                imageable_type: ImageableType::ARTICLE->value,
                variant: 'preview',
                file: $request->input('preview')[0],
                sizes: $this->preview_sizes
            );
        }

        notify("{$hive->get('admin.article_successfully_created')}!");

        $hive->reroute('@admin_articles_index');
    }

    public function update(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $request = $this->request(UpdateArticleRequest::class);
        $request->validate();

        $article = new Article();
        $article->load(['id = ?', $id]);

        if ($article->dry()) {
            throw new Exception('Article not found');
        }

        $article->copyFrom($request->all());
        $article->save();

        if (!empty($request->input('image'))) {
            attach_image_to_model(
                model: $article,
                imageable_type: ImageableType::ARTICLE->value,
                variant: 'image',
                file: $request->input('image')[0],
                sizes: $this->image_sizes
            );
        }

        if (!empty($request->input('preview'))) {
            attach_image_to_model(
                model: $article,
                imageable_type: ImageableType::ARTICLE->value,
                variant: 'preview',
                file: $request->input('preview')[0],
                sizes: $this->preview_sizes
            );
        }

        notify($hive->get('admin.article_successfully_updated'));

        $hive->reroute("@admin_articles_edit(@id=$id)");
    }

    public function destroy(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $article = new Article();
        $article->load(['id = ?', $id]);
        $article->erase();

        notify($hive->get('admin.article_successfully_deleted'));
        $hive->reroute("@admin_articles_index");
    }
}
