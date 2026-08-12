<?php

declare(strict_types=1);

namespace Http\Controllers\Admin;

use Enums\CardVariant;
use Enums\Locale;
use Enums\SessionKey;
use Exception;
use Support\Auth;
use Http\Controller;
use Http\Models\Card;
use Http\Models\FlipCard;
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
        $variant = CardVariant::normalize($hive->GET['variant'] ?? '');
        $locale = Locale::normalize($hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value) ?? '');

        $hive->set('SESSION.' . SessionKey::CARD_VARIANT->value, $variant);

        $card = new FlipCard();
        $card = $card->paginate(
            $page - 1,
            15,
            ['locale=? AND variant=?', $locale, $variant],
            ['order' => 'created_at DESC']
        );

        view('pages/admin/cards/index', [
            'title' => 'All cards',
            'cards' => $card,
        ]);
    }

    public function create(\Base $hive)
    {
        view('pages/admin/cards/create');
    }

    public function edit(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $card = new FlipCard();
        $card->load(['id = ?', $id]);

        view('pages/admin/cards/edit', [
            'title' => $card['name'],
            'card' => $card,
        ]);
    }

    public function show(\Base $hive)
    {

        $id = $hive->PARAMS['id'];
        $card = new FlipCard();
        $card->load(['id = ?', $id]);

        view('pages/admin/cards/show', [
            'title' => $card->title,
            'card' => $card,
        ]);
    }

    public function store(\Base $hive)
    {
        $request = $this->request(StoreCardRequest::class);
        $request->validate();

        $card = new Card();
        $card->copyFrom($request->all());
        $card->save();

        if (! $card->dry() && $request->input('front_image')) {
            ProcessImageJob::dispatch([
                'parent_id'      => $card->id,
                'parent_class'   => Card::class,
                'field'          => 'front_image',
                'sizes'          => ['mb' => 150, 'tb' => 250, 'dk' => 300],
                'files'          => $request->input('front_image'),
                'qnt'            => 1,
            ]);
        }

        notify("{$hive->get('admin.card_successfully_created')}! \n
            {$hive->get('admin.please_wait_for_1-2_minutes_in_order_to_see_updated_image_files')}");
        $hive->reroute('@admin_cards_index');
    }

    public function update(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $request = $this->request(UpdateCardRequest::class);
        $request->validate();

        $card = new Card();
        $card->load(['id = ?', $id]);

        if ($card->dry()) {
            throw new Exception('Card not found');
        }

        $card->copyFrom($request->all());
        $card->save();
        $with_images = false;


        if (! $card->dry() && $request->input('front_image')) {
            $with_images = true;
            ProcessImageJob::dispatch([
                'parent_id'      => $card->id,
                'parent_class'   => Card::class,
                'field'          => 'front_image',
                'sizes'          => ['mb' => 150, 'tb' => 250, 'dk' => 300],
                'files'          => $request->input('front_image'),
                'qnt'            => 1,
            ]);
        }

        $message = "{$hive->get('admin.card_successfully_updated')}!";

        if ($with_images) {
            $message .= "\n{$hive->get('admin.please_wait_for_1-2_minutes_in_order_to_see_updated_image_files')}";
        }

        notify($message);
        $hive->reroute("@admin_cards_edit(@id=$id)");
    }

    public function destroy(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $card = new Card();
        $card->load(['id = ?', $id]);
        $card->erase();

        notify($hive->get('admin.card_successfully_deleted'));
        $hive->reroute("@admin_cards_index");
    }
}
