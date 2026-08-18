<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Enums\FAQVariant;
use Enums\Locale;
use Enums\SessionKey;
use Exception;
use Support\Auth;
use Http\Controller;
use Http\Models\FAQ;
use Http\Models\FlipFAQ;
use Http\Requests\CRUD\FAQ\StoreFAQRequest;
use Http\Requests\CRUD\FAQ\UpdateFAQRequest;
use Jobs\ProcessImageJob;

class FAQController extends Controller
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
        $variant = FAQVariant::normalize($hive->GET['variant'] ?? '');
        $locale = Locale::normalize($hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value) ?? '');

        $hive->set('SESSION.' . SessionKey::faq_VARIANT->value, $variant);

        $faq = new FlipFAQ();
        $faq = $faq->paginate(
            $page - 1,
            15,
            ['locale=? AND variant=?', $locale, $variant],
            ['order' => 'created_at DESC']
        );

        $backside = null;

        if (! empty($faq['subset'])) {
            $item = $faq['subset'][0];
            $backside = [
                'id' => $item->back_id,
                'src' => $item->back_src,
                'alt' => $item->back_alt,
            ];
        }

        view('pages/admin/faqs/index', [
            'title' => 'All faqs',
            'faqs' => $faq,
            'backside' => $backside,
        ]);
    }

    public function create(\Base $hive)
    {
        view('pages/admin/faqs/create');
    }

    public function edit(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $faq = new FlipFAQ();
        $faq->load(['id = ?', $id]);

        view('pages/admin/faqs/edit', [
            'title' => $faq['name'],
            'faq' => $faq->to_resource(),
        ]);
    }

    public function show(\Base $hive)
    {

        $id = $hive->PARAMS['id'];
        $faq = new FlipFAQ();
        $faq->load(['id = ?', $id]);

        view('pages/admin/faqs/show', [
            'title' => $faq->name,
            'faq' => $faq->to_resource(),
        ]);
    }

    public function store(\Base $hive)
    {
        $request = $this->request(StoreFAQRequest::class);
        $request->validate();
        $variant = $request->input('variant');

        $faq = new FAQ();
        $faq->copyFrom($request->all());
        $faq->save();

        if (! $faq->dry() && $request->input('front_image')) {
            ProcessImageJob::dispatch([
                'imageable_id'      => $faq->id,
                'imageable_type'   => $variant,
                'variant'          => 'front',
                'sizes'          => ['mb' => 150, 'tb' => 250, 'dk' => 300],
                'files'          => $request->input('front_image'),
                'qnt'            => 1,
            ]);
        }

        notify("{$hive->get('admin.faq_successfully_created')}! \n
            {$hive->get('admin.please_wait_for_1-2_minutes_in_order_to_see_updated_image_files')}");

        $hive->reroute('@admin_faqs_index' . '?' . http_build_query(['variant' => $variant]));
    }

    public function update(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $request = $this->request(UpdateFAQRequest::class);
        $request->validate();

        $faq = new FAQ();
        $faq->load(['id = ?', $id]);

        if ($faq->dry()) {
            throw new Exception('FAQ not found');
        }

        $faq->copyFrom($request->all());
        $faq->save();
        $with_images = false;


        if (! $faq->dry() && $request->input('front_image')) {
            $with_images = true;
            ProcessImageJob::dispatch([
                'imageable_id'      => $faq->id,
                'imageable_type'   => $request->input('variant'),
                'variant'          => 'front',
                'sizes'          => ['mb' => 150, 'tb' => 250, 'dk' => 300],
                'files'          => $request->input('front_image'),
                'qnt'            => 1,
            ]);
        }

        $message = "{$hive->get('admin.faq_successfully_updated')}!";

        if ($with_images) {
            $message .= "\n{$hive->get('admin.please_wait_for_1-2_minutes_in_order_to_see_updated_image_files')}";
        }

        notify($message);

        $hive->reroute("@admin_faqs_edit(@id=$id)");
    }

    public function destroy(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $faq = new FAQ();
        $faq->load(['id = ?', $id]);
        $faq->erase();

        notify($hive->get('admin.faq_successfully_deleted'));
        $hive->reroute("@admin_faqs_index");
    }
}
