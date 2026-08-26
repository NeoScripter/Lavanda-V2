<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Enums\ImageableType;
use Enums\Locale;
use Enums\SessionKey;
use Enums\ThemeableType;
use Exception;
use Http\Controller;
use Http\Models\Rune;
use Http\Models\RuneAsset;
use Http\Requests\CRUD\Rune\StoreRuneRequest;
use Http\Requests\CRUD\Rune\UpdateRuneRequest;
use Traits\RequiresAuth;

class RuneController extends Controller
{
    use RequiresAuth;

    private $image_sizes = ['mb' => 120, 'tb' => 200];

    public function index(\Base $hive)
    {
        $page = $hive->GET['page'] ?? 1;
        $page = is_numeric($page) ? (int) $page : 1;
        $locale = Locale::normalize($hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value) ?? '');


        $rune = new RuneAsset();
        $rune = $rune->paginate(
            $page - 1,
            15,
            ['locale=?', $locale],
            ['order' => 'created_at DESC']
        );

        view('pages/admin/runes/index', [
            'title' => 'All runes',
            'runes' => $rune,
        ]);
    }

    public function create()
    {
        view('pages/admin/runes/create');
    }

    public function edit(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $rune = new RuneAsset();
        $rune->load(['id = ?', $id]);

        view('pages/admin/runes/edit', [
            'title' => $rune['name'],
            'rune' => $rune->to_resource(),
            'themes' => get_unique_themes_by_type(ThemeableType::RUNE, $id),
        ]);
    }

    public function show(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $rune = new Rune();
        $rune->load(['id = ?', $id]);
        $themes = $rune->themes;

        $rune = new RuneAsset();
        $rune->load(['id = ?', $id]);

        view('pages/admin/runes/show', [
            'title' => $rune->name,
            'rune' => $rune->to_resource(),
            'themes' => $themes,
        ]);
    }

    public function store(\Base $hive)
    {
        $request = $this->request(StoreRuneRequest::class);
        $request->validate();
        $variant = $request->input('variant');

        $rune = new Rune();
        $rune->copyFrom($request->all());
        $rune->save();

        if (! $rune->dry() && !empty($request->input('front_image'))) {
            attach_image_to_model(
                model: $rune,
                imageable_type: ImageableType::RUNE->value,
                variant: 'front_image',
                file: $request->input('front_image')[0],
                sizes: $this->image_sizes
            );
        }

        if (! $rune->dry() && !empty($request->input('back_image'))) {
            attach_image_to_model(
                model: $rune,
                imageable_type: ImageableType::RUNE->value,
                variant: 'back_image',
                file: $request->input('back_image')[0],
                sizes: $this->image_sizes
            );
        }

        notify($hive->get('admin.rune_successfully_created'));

        $hive->reroute('@admin_runes_index' . '?' . http_build_query(['variant' => $variant]));
    }

    public function update(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $request = $this->request(UpdateRuneRequest::class);
        $request->validate();

        $rune = new Rune();
        $rune->load(['id = ?', $id]);

        if ($rune->dry()) {
            throw new Exception('Rune not found');
        }

        $rune->copyFrom($request->all());
        $rune->save();

        if (!empty($request->input('front_image'))) {
            attach_image_to_model(
                model: $rune,
                imageable_type: ImageableType::RUNE->value,
                variant: 'front_image',
                file: $request->input('front_image')[0],
                sizes: $this->image_sizes
            );
        }

        if (!empty($request->input('back_image'))) {
            attach_image_to_model(
                model: $rune,
                imageable_type: ImageableType::RUNE->value,
                variant: 'back_image',
                file: $request->input('back_image')[0],
                sizes: $this->image_sizes
            );
        }

        notify($hive->get('admin.rune_successfully_updated'));

        $hive->reroute("@admin_runes_edit(@id=$id)");
    }

    public function destroy(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $rune = new Rune();
        $rune->load(['id = ?', $id]);
        $rune->erase();

        notify($hive->get('admin.rune_successfully_deleted'));
        $hive->reroute("@admin_runes_index");
    }
}
