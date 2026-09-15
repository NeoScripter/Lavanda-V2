<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Enums\Locale;
use Enums\SessionKey;
use Exception;
use Http\Controller;
use Http\Models\Affirmation;
use Http\Requests\CRUD\Affirmation\StoreAffirmationRequest;
use Http\Requests\CRUD\Affirmation\UpdateAffirmationRequest;
use Traits\RequiresAuth;

class AffirmationController extends Controller
{
    use RequiresAuth;

    public function index(\Base $hive)
    {
        $locale = Locale::normalize($hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value) ?? '');

        $topics = get_unique_affirmation_topics(Locale::from($locale));
        $selected_topic = urldecode($hive->GET['topic'] ?? $topics[0] ?? '');
        $hive->set('SESSION.' . SessionKey::AFFIRMATION_TOPIC->value, $selected_topic);


        $affirmations = new Affirmation();
        $affirmations = $affirmations->find(
            ['locale=? AND topic=?', $locale, $selected_topic],
            ['order' => 'created_at DESC']
        );

        view('pages/admin/affirmations/index', [
            'title' => $hive->get('admin.affirmations'),
            'affirmations' => $affirmations,
            'topics' => $topics,
        ]);
    }

    public function create(\Base $hive)
    {
        $locale = Locale::normalize($hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value) ?? '');
        $topics = get_unique_affirmation_topics(Locale::from($locale));
        view('pages/admin/affirmations/create', ['topics' => $topics]);
    }

    public function edit(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $affirmation = new Affirmation();
        $affirmation->load(['id = ?', $id]);
        $topics = get_unique_affirmation_topics(Locale::from($affirmation->locale));

        view('pages/admin/affirmations/edit', [
            'title' => $hive->get('admin.affirmations'),
            'affirmation' => $affirmation,
            'topics' => $topics,
        ]);
    }

    public function store(\Base $hive)
    {
        $request = $this->request(StoreAffirmationRequest::class);
        $request->validate();

        $affirmation = new Affirmation();
        $affirmation->copyFrom($request->all());
        $affirmation->save();

        notify($hive->get('admin.affirmation_successfully_created'));

        $hive->reroute('@admin_affirmations_index');
    }

    public function update(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $request = $this->request(UpdateAffirmationRequest::class);
        $request->validate();

        $affirmation = new Affirmation();
        $affirmation->load(['id = ?', $id]);

        if ($affirmation->dry()) {
            throw new Exception('Affirmation not found');
        }

        $affirmation->copyFrom($request->all());
        $affirmation->save();

        notify($hive->get('admin.affirmation_successfully_updated'));

        $hive->reroute("@admin_affirmations_edit(@id=$id)");
    }

    public function destroy(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $affirmation = new Affirmation();
        $affirmation->load(['id = ?', $id]);
        $affirmation->erase();

        notify($hive->get('admin.affirmation_successfully_deleted'));
        $hive->reroute("@admin_affirmations_index");
    }
}
