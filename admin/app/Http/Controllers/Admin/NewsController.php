<?php

declare(strict_types=1);

namespace Http\Controllers\Admin;

use Exception;
use Support\Auth;
use Http\Controller;
use Http\Models\News;
use Http\Requests\News\StoreNewsRequest;
use Http\Requests\News\UpdateNewsRequest;
use Jobs\ProcessImageJob;

class NewsController extends Controller
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
        $news = new News();
        $news = $news->paginate($page - 1, 5, [], ['order' => 'created_at DESC']);

        view('pages/admin/news/index', [
            'title' => 'All Newsletters',
            'news' => $news,
        ]);
    }

    public function create()
    {
        view('pages/admin/news/create');
    }

    public function edit(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $article = new News();
        $article->load(['id = ?', $id]);

        view('pages/admin/news/edit', [
            'title' => $article->title,
            'article' => $article,
        ]);
    }

    public function show(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $article = new News();
        $article->load(['id = ?', $id]);

        view('pages/admin/news/show', [
            'title' => $article->title,
            'article' => $article,
        ]);
    }

    public function store(\Base $hive)
    {
        $request = $this->request(StoreNewsRequest::class);
        $request->validate();

        $news = new News();
        $data = $request->all();
        unset($data['preview'], $data['gallery']);
        $news->copyFrom($data);
        $news->save();

        if (! $news->dry() && $request->input('preview')) {
            ProcessImageJob::dispatch([
                'parent_id'      => $news->id,
                'parent_class'   => News::class,
                'field'          => 'image',
                'sizes'          => ['mb' => 350, 'tb' => 600],
                'files'          => $request->input('preview'),
                'qnt'            => 1,
            ]);
        }

        if (! $news->dry() && $request->input('gallery')) {
            ProcessImageJob::dispatch([
                'parent_id'      => $news->id,
                'parent_class'   => News::class,
                'field'          => 'gallery',
                'sizes'          => ['mb' => 350, 'dk' => 1000],
                'files'          => $request->input('gallery'),
            ]);
        }

        notify("Newsletter successfully created! \nPlease wait for 2-10 minutes in order to see updated image files");
        $hive->reroute('@admin_news_index');
    }

    public function update(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $request = $this->request(UpdateNewsRequest::class);
        $request->validate();

        $news = new News();
        $news->load(['id = ?', $id]);

        if ($news->dry()) {
            throw new Exception('Newsletter not found');
        }

        $data = $request->all();
        unset($data['preview'], $data['gallery']);
        $news->copyFrom($data);
        $news->save();
        $with_images = false;

        if (! $news->dry() && $request->input('preview')) {
            $with_images = true;
            ProcessImageJob::dispatch([
                'parent_id'      => $news->id,
                'parent_class'   => News::class,
                'field'          => 'image',
                'sizes'          => ['mb' => 350, 'tb' => 600],
                'files'          => $request->input('preview'),
                'qnt'            => 1,
            ]);
        }

        if (! $news->dry() && $request->input('gallery')) {
            $with_images = true;
            ProcessImageJob::dispatch([
                'parent_id'      => $news->id,
                'parent_class'   => News::class,
                'field'          => 'gallery',
                'sizes'          => ['mb' => 350, 'dk' => 1000],
                'files'          => $request->input('gallery'),
            ]);
        }

        $message = 'Newsletter successfully updated!';

        if ($with_images) {
            $message .= "\nPlease wait for 2-10 minutes in order to see updated image files";
        }

        notify($message);
        $hive->reroute("@admin_news_edit(@id=$id)");
    }

    public function destroy(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $news = new News();
        $news->load(['id = ?', $id]);
        $news->erase();

        notify('Newsletter successfully deleted!');
        $hive->reroute("@admin_news_index");
    }
}
