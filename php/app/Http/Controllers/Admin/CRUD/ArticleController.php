<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Exception;
use Support\Auth;
use Http\Controller;
use Http\Models\Article;
use Http\Requests\Article\StoreArticleRequest;
use Http\Requests\Article\UpdateArticleRequest;
use Jobs\ProcessImageJob;

class ArticleController extends Controller
{
    public function beforeroute(\Base $hive)
    {
        if (! Auth::check()) {
            $hive->reroute('@login');
        }
    }

    public function index(\Base $hive)
    {
        $page = $hive->GET['page'] ?? 1;
        $page = is_numeric($page) ? (int) $page : 1;
        $articles = new Article();
        $articles = $articles->paginate($page - 1, 5, [], ['order' => 'created_at DESC']);

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
            'title' => $article->title,
            'article' => $article,
        ]);
    }

    public function show(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $article = new Article();
        $article->load(['id = ?', $id]);

        view('pages/admin/articles/show', [
            'title' => $article->title,
            'article' => $article,
        ]);
    }

    public function store(\Base $hive)
    {
        $request = $this->request(StoreArticleRequest::class);
        $request->validate();

        $article = new Article();
        $data = $request->all();
        unset($data['preview']);
        $article->copyFrom($data);
        $article->save();

        if (! $article->dry() && $request->input('preview')) {
            ProcessImageJob::dispatch([
                'parent_id'      => $article->id,
                'parent_class'   => Article::class,
                'field'          => 'image',
                'sizes'          => ['mb' => 350, 'tb' => 600],
                'files'          => $request->input('preview'),
                'qnt'            => 1,
            ]);
        }

        notify("Article successfully created! \nPlease wait for 2-10 minutes in order to see updated image files");
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

        $data = $request->all();
        unset($data['preview']);
        $article->copyFrom($data);
        $article->save();
        $with_images = false;

        if (! $article->dry() && $request->input('preview') != null) {
            $with_images = true;
            ProcessImageJob::dispatch([
                'parent_id'      => $article->id,
                'parent_class'   => Article::class,
                'field'          => 'image',
                'sizes'          => ['mb' => 350, 'tb' => 600],
                'files'          => $request->input('preview'),
                'qnt'            => 1,
            ]);
        }

        $message = 'Article successfully updated!';

        if ($with_images) {
            $message .= "\nPlease wait for 2-10 minutes in order to see updated image files";
        }

        notify($message);
        $hive->reroute("@admin_articles_edit(@id=$id)");
    }

    public function destroy(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $articles = new Article();
        $articles->load(['id = ?', $id]);
        $articles->erase();

        notify('Article successfully deleted!');
        $hive->reroute("@admin_articles_index");
    }
}
