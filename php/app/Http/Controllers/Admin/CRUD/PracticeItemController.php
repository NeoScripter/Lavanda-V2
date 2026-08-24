<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Enums\ImageableType;
use Enums\Locale;
use Enums\SessionKey;
use Exception;
use Http\Controller;
use Http\Models\PracticeItem;
use Http\Models\PracticeItemAsset;
use Http\Requests\CRUD\PracticeItem\StorePracticeItemRequest;
use Http\Requests\CRUD\PracticeItem\UpdatePracticeItemRequest;
use Jobs\ProcessImageJob;
use Traits\RequiresAuth;

class PracticeItemController extends Controller
{
    use RequiresAuth;

    public function index(\Base $hive)
    {
        $page = $hive->GET['page'] ?? 1;
        $page = is_numeric($page) ? (int) $page : 1;
        $locale = Locale::normalize($hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value) ?? '');

        $item = new PracticeItemAsset();
        $item = $item->paginate(
            $page - 1,
            15,
            ['locale=?', $locale],
            ['order' => 'created_at DESC']
        );

        view('pages/admin/practice_items/index', [
            'title' => 'All practice_items',
            'items' => $item,
        ]);
    }

    public function create(\Base $hive)
    {
        view('pages/admin/practice_items/create');
    }

    public function edit(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $item = new PracticeItemAsset();
        $item->load(['id = ?', $id]);

        view('pages/admin/practice_items/edit', [
            'title' => $item->title,
            'item' => $item->to_resource(),
        ]);
    }

    public function show(\Base $hive)
    {

        $id = $hive->PARAMS['id'];
        $item = new PracticeItemAsset();
        $item->load(['id = ?', $id]);

        view('pages/admin/practice_items/show', [
            'title' => $item->title,
            'item' => $item->to_resource(),
        ]);
    }

    public function store(\Base $hive)
    {
        $request = $this->request(StorePracticeItemRequest::class);
        $request->validate();

        $item = new PracticeItem();
        $item->copyFrom($request->all());
        $item->save();

        if (! $item->dry() && $request->input('image')) {
            ProcessImageJob::dispatch([
                'imageable_id'      => $item->id,
                'imageable_type'   => ImageableType::PRACTICE_ITEM->value,
                'variant'          => 'image',
                'sizes'          => ['mb' => 450, 'tb' => 600, 'dk' => 750],
                'files'          => $request->input('image'),
                'qnt'            => 1,
            ]);
        }

        notify("{$hive->get('admin.item_successfully_created')}! \n
            {$hive->get('admin.please_wait_for_1-2_minutes_in_order_to_see_updated_image_files')}");

        $hive->reroute('@admin_practice_items_index' . '?' . http_build_query(['variant' => $variant]));
    }

    public function update(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $request = $this->request(UpdatePracticeItemRequest::class);
        $request->validate();

        $item = new PracticeItem();
        $item->load(['id = ?', $id]);

        if ($item->dry()) {
            throw new Exception('PracticeItem not found');
        }

        $item->copyFrom($request->all());
        $item->save();
        $with_images = false;


        if (! $item->dry() && $request->input('image')) {
            $with_images = true;
            ProcessImageJob::dispatch([
                'imageable_id'      => $item->id,
                'imageable_type'   => ImageableType::PRACTICE_ITEM->value,
                'variant'          => 'image',
                'sizes'          => ['mb' => 450, 'tb' => 600, 'dk' => 750],
                'files'          => $request->input('image'),
                'qnt'            => 1,
            ]);
        }

        $message = "{$hive->get('admin.item_successfully_updated')}!";

        if ($with_images) {
            $message .= "\n{$hive->get('admin.please_wait_for_1-2_minutes_in_order_to_see_updated_image_files')}";
        }

        notify($message);

        $hive->reroute("@admin_practice_items_edit(@id=$id)");
    }

    public function destroy(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $item = new PracticeItem();
        $item->load(['id = ?', $id]);
        $item->erase();

        notify($hive->get('admin.item_successfully_deleted'));
        $hive->reroute("@admin_practice_items_index");
    }
}
