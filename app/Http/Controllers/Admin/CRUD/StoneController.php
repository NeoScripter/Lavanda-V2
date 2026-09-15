<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Enums\ImageableType;
use Enums\Locale;
use Enums\SessionKey;
use Exception;
use Http\Controller;
use Http\Models\Stone;
use Http\Models\StoneAsset;
use Http\Requests\CRUD\Stone\StoreStoneRequest;
use Http\Requests\CRUD\Stone\UpdateStoneRequest;
use Traits\RequiresAuth;

class StoneController extends Controller
{
    use RequiresAuth;

    private $preview_sizes = ['mb' => 120];
    private $image_sizes = ['mb' => 120, 'tb' => 240];

    public function index(\Base $hive)
    {
        $page = $hive->GET['page'] ?? 1;
        $page = is_numeric($page) ? (int) $page : 1;
        $locale = Locale::normalize($hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value) ?? '');


        $stone = new StoneAsset();
        $stone = $stone->paginate(
            $page - 1,
            15,
            ['locale=?', $locale],
            ['order' => 'created_at DESC']
        );

        view('pages/admin/stones/index', [
            'title' => 'All stones',
            'stones' => $stone,
        ]);
    }

    public function create()
    {
        view('pages/admin/stones/create');
    }

    public function edit(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $stone = new StoneAsset();
        $stone->load(['id = ?', $id]);

        view('pages/admin/stones/edit', [
            'title' => $stone['name'],
            'heading' => $hive->get('admin.edit_stone') . ' ' . $stone['name'],
            'stone' => $stone->to_resource(),
        ]);
    }

    public function show(\Base $hive)
    {
        $id = $hive->PARAMS['id'];

        $stone = new StoneAsset();
        $stone->load(['id = ?', $id]);

        view('pages/admin/stones/show', [
            'title' => $stone->name,
            'stone' => $stone->to_resource(),
        ]);
    }

    public function store(\Base $hive)
    {
        $request = $this->request(StoreStoneRequest::class);
        $request->validate();

        $stone = new Stone();
        $stone->copyFrom($request->all());
        $stone->save();

        if (! $stone->dry() && !empty($request->input('preview'))) {
            attach_image_to_model(
                model: $stone,
                imageable_type: ImageableType::STONE->value,
                variant: 'preview',
                file: $request->input('preview')[0],
                sizes: $this->preview_sizes
            );
        }

        if (! $stone->dry() && !empty($request->input('image'))) {
            attach_image_to_model(
                model: $stone,
                imageable_type: ImageableType::STONE->value,
                variant: 'image',
                file: $request->input('image')[0],
                sizes: $this->image_sizes
            );
        }

        notify($hive->get('admin.stone_successfully_created'));

        $hive->reroute('@admin_stones_index');
    }

    public function update(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $request = $this->request(UpdateStoneRequest::class);
        $request->validate();

        $stone = new Stone();
        $stone->load(['id = ?', $id]);

        if ($stone->dry()) {
            throw new Exception('Stone not found');
        }

        $stone->copyFrom($request->all());
        $stone->save();

        if (!empty($request->input('preview'))) {
            attach_image_to_model(
                model: $stone,
                imageable_type: ImageableType::STONE->value,
                variant: 'preview',
                file: $request->input('preview')[0],
                sizes: $this->preview_sizes
            );
        }

        if (!empty($request->input('image'))) {
            attach_image_to_model(
                model: $stone,
                imageable_type: ImageableType::STONE->value,
                variant: 'image',
                file: $request->input('image')[0],
                sizes: $this->image_sizes
            );
        }

        notify($hive->get('admin.stone_successfully_updated'));

        $hive->reroute("@admin_stones_edit(@id=$id)");
    }

    public function destroy(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $stone = new Stone();
        $stone->load(['id = ?', $id]);
        $stone->erase();

        notify($hive->get('admin.stone_successfully_deleted'));
        $hive->reroute("@admin_stones_index");
    }
}
