<?php

declare(strict_types=1);

namespace Http\Controllers\Admin;

use Exception;
use Support\Auth;
use Http\Controller;
use Http\Models\Card;
use Http\Requests\Card\StoreCardRequest;
use Http\Requests\Card\UpdateCardRequest;
use Jobs\ProcessImageJob;

class CardController extends Controller
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
        $cards = new Card();
        $cards = $cards->paginate($page - 1, 5, [], ['order' => 'created_at DESC']);

        view('pages/admin/cards/index', [
            'title' => 'All cards',
            'cards' => $cards,
        ]);
    }

    public function create()
    {
        view('pages/admin/cards/create');
    }

    public function edit(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $article = new Card();
        $article->load(['id = ?', $id]);

        view('pages/admin/cards/edit', [
            'title' => $article->title,
            'article' => $article,
        ]);
    }

    public function show(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $article = new Card();
        $article->load(['id = ?', $id]);

        view('pages/admin/cards/show', [
            'title' => $article->title,
            'article' => $article,
        ]);
    }

    public function store(\Base $hive)
    {
        $request = $this->request(StoreCardRequest::class);
        $request->validate();

        $cards = new Card();
        $data = $request->all();
        unset($data['preview'], $data['gallery']);
        $cards->copyFrom($data);
        $cards->save();

        if (! $cards->dry() && $request->input('preview')) {
            ProcessImageJob::dispatch([
                'parent_id'      => $cards->id,
                'parent_class'   => Card::class,
                'field'          => 'image',
                'sizes'          => ['mb' => 350, 'tb' => 600],
                'files'          => $request->input('preview'),
                'qnt'            => 1,
            ]);
        }

        if (! $cards->dry() && $request->input('gallery')) {
            ProcessImageJob::dispatch([
                'parent_id'      => $cards->id,
                'parent_class'   => Card::class,
                'field'          => 'gallery',
                'sizes'          => ['mb' => 350, 'dk' => 1000],
                'files'          => $request->input('gallery'),
            ]);
        }

        notify("Card successfully created! \nPlease wait for 2-10 minutes in order to see updated image files");
        $hive->reroute('@admin_cards_index');
    }

    public function update(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $request = $this->request(UpdateCardRequest::class);
        $request->validate();

        $cards = new Card();
        $cards->load(['id = ?', $id]);

        if ($cards->dry()) {
            throw new Exception('Card not found');
        }

        $data = $request->all();
        unset($data['preview'], $data['gallery']);
        $cards->copyFrom($data);
        $cards->save();
        $with_images = false;

        if (! $cards->dry() && $request->input('preview')) {
            $with_images = true;
            ProcessImageJob::dispatch([
                'parent_id'      => $cards->id,
                'parent_class'   => Card::class,
                'field'          => 'image',
                'sizes'          => ['mb' => 350, 'tb' => 600],
                'files'          => $request->input('preview'),
                'qnt'            => 1,
            ]);
        }

        if (! $cards->dry() && $request->input('gallery')) {
            $with_images = true;
            ProcessImageJob::dispatch([
                'parent_id'      => $cards->id,
                'parent_class'   => Card::class,
                'field'          => 'gallery',
                'sizes'          => ['mb' => 350, 'dk' => 1000],
                'files'          => $request->input('gallery'),
            ]);
        }

        $message = 'Card successfully updated!';

        if ($with_images) {
            $message .= "\nPlease wait for 2-10 minutes in order to see updated image files";
        }

        notify($message);
        $hive->reroute("@admin_cards_edit(@id=$id)");
    }

    public function destroy(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $cards = new Card();
        $cards->load(['id = ?', $id]);
        $cards->erase();

        notify('Card successfully deleted!');
        $hive->reroute("@admin_cards_index");
    }
}
