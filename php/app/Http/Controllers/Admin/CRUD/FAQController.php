<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Enums\Locale;
use Enums\SessionKey;
use Exception;
use Http\Controller;
use Http\Models\FAQ;
use Http\Requests\CRUD\FAQ\StoreFAQRequest;
use Http\Requests\CRUD\FAQ\UpdateFAQRequest;
use Traits\RequiresAuth;

class FAQController extends Controller
{
    use RequiresAuth;

    public function index(\Base $hive)
    {
        $locale = Locale::normalize($hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value) ?? '');

        $faqs = new FAQ();
        $faqs = $faqs->find(
            ['locale=?', $locale],
            ['order' => 'created_at DESC']
        );

        view('pages/admin/faqs/index', [
            'title' => 'All faqs',
            'faqs' => $faqs,
        ]);
    }

    public function create(\Base $hive)
    {
        view('pages/admin/faqs/create');
    }

    public function edit(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $faq = new FAQ();
        $faq->load(['id = ?', $id]);

        view('pages/admin/faqs/edit', [
            'title' => 'FAQs',
            'faq' => $faq,
        ]);
    }

    public function show(\Base $hive)
    {

        $id = $hive->PARAMS['id'];
        $faq = new FAQ();
        $faq->load(['id = ?', $id]);

        view('pages/admin/faqs/show', [
            'title' => $faq->name,
            'faq' => $faq,
        ]);
    }

    public function store(\Base $hive)
    {
        $request = $this->request(StoreFAQRequest::class);
        $request->validate();

        $faq = new FAQ();
        $faq->copyFrom($request->all());
        $faq->save();

        notify("{$hive->get('admin.faq_successfully_created')}! \n
            {$hive->get('admin.please_wait_for_1-2_minutes_in_order_to_see_updated_image_files')}");

        $hive->reroute('@admin_faqs_index');
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

        $message = "{$hive->get('admin.faq_successfully_updated')}!";

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
