<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Enums\Locale;
use Enums\MatcheableType;
use Enums\SessionKey;
use Exception;
use Http\Controller;
use Http\Models\Image;
use Http\Models\MatchSet;
use Http\Models\MatchSetImage;
use Http\Requests\CRUD\MatchSet\StoreMatchSetRequest;
use Http\Requests\CRUD\MatchSet\UpdateMatchSetRequest;
use Traits\RequiresAuth;

class MatchSetController extends Controller
{
    use RequiresAuth;

    private string $mt_type;
    private string $locale;

    public function __construct()
    {
        $hive = \Base::instance();

        $this->mt_type = MatcheableType::normalize($hive->GET['matcheable_type'] ??
            $hive->get('SESSION.' . SessionKey::MATCHEABLE_TYPE->value) ?? '');
        $this->locale = Locale::normalize($hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value) ?? '');
    }

    public function index(\Base $hive)
    {
        $page = $hive->GET['page'] ?? 1;
        $page = is_numeric($page) ? (int) $page : 1;

        $hive->set('SESSION.' . SessionKey::MATCHEABLE_TYPE->value, $this->mt_type);

        $match_sets = new MatchSetImage();
        $match_sets = $match_sets->paginate(
            $page - 1,
            15,
            ['locale=? AND matcheable_type=?', $this->locale, $this->mt_type],
            ['order' => 'created_at DESC']
        );

        view('pages/admin/match_sets/index', [
            'title' => 'All sets',
            'match_sets' => $match_sets,
        ]);
    }

    public function create()
    {
        $img_variant = match ($this->mt_type) {
            MatcheableType::RUNE->value => 'front_image',
            MatcheableType::STONE->value => 'preview',
            default => 'front_image'
        };

        $images = new Image();
        $images = $images->find(['imageable_type = ? AND variant = ?', $this->mt_type, $img_variant]);

        view('pages/admin/match_sets/create', compact('images'));
    }

    public function edit(\Base $hive)
    {
        $img_variant = match ($this->mt_type) {
            MatcheableType::RUNE->value => 'front_image',
            MatcheableType::STONE->value => 'preview',
            default => 'front_image'
        };

        $images = new Image();
        $images = $images->find(['imageable_type = ? AND variant = ?', $this->mt_type, $img_variant]);

        $id = $hive->PARAMS['id'];
        $set = new MatchSetImage();
        $set->load(['id = ?', $id]);

        view('pages/admin/match_sets/edit', [
            'title' => 'Match Set',
            'set' => $set,
            'images' => $images,
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
        dd($request->all());
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
