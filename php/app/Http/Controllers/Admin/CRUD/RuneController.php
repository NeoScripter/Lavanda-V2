<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Enums\ImageableType;
use Enums\Locale;
use Enums\RuneTheme as RuneThemeEnum;
use Enums\SessionKey;
use Exception;
use Http\Controller;
use Http\Models\Rune;
use Http\Models\RuneAsset;
use Http\Models\RuneTheme;
use Http\Requests\CRUD\Rune\StoreRuneRequest;
use Http\Requests\CRUD\Rune\UpdateRuneRequest;
use Jobs\ProcessImageJob;
use Traits\RequiresAuth;

class RuneController extends Controller
{
    use RequiresAuth;

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

    public function create(\Base $hive)
    {
        view('pages/admin/runes/create');
    }

    public function edit(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $rune = new Rune();
        $rune->load(['id = ?', $id]);
        $themes = $rune->themes;

        $rune = new RuneAsset();
        $rune->load(['id = ?', $id]);

        view('pages/admin/runes/edit', [
            'title' => $rune['name'],
            'rune' => $rune->to_resource(),
            'themes' => $themes,
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

        if (! $rune->dry() && $request->input('front_image')) {
            ProcessImageJob::dispatch([
                'imageable_id'      => $rune->id,
                'imageable_type'   => ImageableType::RUNE->value,
                'variant'          => 'front',
                'sizes'          => ['mb' => 120, 'tb' => 200],
                'files'          => $request->input('front_image'),
                'qnt'            => 1,
            ]);
        }

        if (! $rune->dry() && $request->input('back_image')) {
            ProcessImageJob::dispatch([
                'imageable_id'      => $rune->id,
                'imageable_type'   => ImageableType::RUNE->value,
                'variant'          => 'back',
                'sizes'          => ['mb' => 120, 'tb' => 200],
                'files'          => $request->input('back_image'),
                'qnt'            => 1,
            ]);
        }

        foreach (RuneThemeEnum::values() as $name) {
            $theme = new RuneTheme();
            $theme->name = $name;
            $theme->html = 'Placeholder';
            $theme->rune = $rune;
            $theme->save();
        }

        notify("{$hive->get('admin.rune_successfully_created')}! \n
            {$hive->get('admin.please_wait_for_1-2_minutes_in_order_to_see_updated_image_files')}");

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
        $with_images = false;


        if (! $rune->dry() && $request->input('front_image')) {
            $with_images = true;
            ProcessImageJob::dispatch([
                'imageable_id'      => $rune->id,
                'imageable_type'   => ImageableType::RUNE->value,
                'variant'          => 'front',
                'sizes'          => ['mb' => 120, 'tb' => 200],
                'files'          => $request->input('front_image'),
                'qnt'            => 1,
            ]);
        }

        if (! $rune->dry() && $request->input('back_image')) {
            ProcessImageJob::dispatch([
                'imageable_id'      => $rune->id,
                'imageable_type'   => ImageableType::RUNE->value,
                'variant'          => 'back',
                'sizes'          => ['mb' => 120, 'tb' => 200],
                'files'          => $request->input('back_image'),
                'qnt'            => 1,
            ]);
        }

        $message = "{$hive->get('admin.rune_successfully_updated')}!";

        if ($with_images) {
            $message .= "\n{$hive->get('admin.please_wait_for_1-2_minutes_in_order_to_see_updated_image_files')}";
        }

        notify($message);

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
