<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Enums\Locale;
use Enums\MatcheableType;
use Enums\SessionKey;
use Exception;
use Http\Controller;
use Http\Models\MatchSet;
use Http\Models\MatchSetImage;
use Http\Requests\CRUD\MatchSet\StoreMatchSetRequest;
use Http\Requests\CRUD\MatchSet\UpdateMatchSetRequest;
use Traits\RequiresAuth;

class MatchSetController extends Controller
{
    use RequiresAuth;

    public function index(\Base $hive)
    {
        $page = $hive->GET['page'] ?? 1;
        $page = is_numeric($page) ? (int) $page : 1;
        $mt_type = MatcheableType::normalize($hive->GET['matcheable_type'] ?? '');
        $locale = Locale::normalize($hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value) ?? '');

        $hive->set('SESSION.' . SessionKey::MATCHEABLE_TYPE->value, $mt_type);

        $match_sets = new MatchSetImage();
        $match_sets = $match_sets->paginate(
            $page - 1,
            15,
            ['locale=? AND matcheable_type=?', $locale, $mt_type],
            ['order' => 'created_at DESC']
        );

        view('pages/admin/match_sets/index', [
            'title' => 'All sets',
            'match_sets' => $match_sets,
        ]);
    }

    public function create()
    {
        view('pages/admin/match_sets/create');
    }

    public function edit(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $set = new MatchSetImage();
        $set->load(['id = ?', $id]);

        view('pages/admin/match_sets/edit', [
            'title' => 'Match Set',
            'set' => $set,
        ]);
    }

    public function show(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $set = new MatchSetImage();
        $set->load(['id = ?', $id]);

        view('pages/admin/match_sets/show', [
            'title' => 'Match Set',
            'set' => $set,
        ]);
    }

    public function store(\Base $hive)
    {
        $request = $this->request(StoreMatchSetRequest::class);
        $request->validate();
        $mt_type = $request->input('matcheable_type');

        $set = new MatchSet();
        $set->copyFrom($request->all());
        $set->save();

        notify("{$hive->get('admin.set_successfully_created')}!");

        $hive->reroute('@admin_match_sets_index' . '?' . http_build_query(['matcheable_type' => $mt_type]));
    }

    public function update(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $request = $this->request(UpdateMatchSetRequest::class);
        $request->validate();

        $set = new MatchSet();
        $set->load(['id = ?', $id]);

        if ($set->dry()) {
            throw new Exception('MatchSet not found');
        }

        $set->copyFrom($request->all());
        $set->save();

        notify($hive->get('admin.set_successfully_updated'));

        $hive->reroute("@admin_match_sets_edit(@id=$id)");
    }

    public function destroy(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $set = new MatchSet();
        $set->load(['id = ?', $id]);
        $set->erase();

        notify($hive->get('admin.set_successfully_deleted'));
        $hive->reroute("@admin_match_sets_index");
    }
}
