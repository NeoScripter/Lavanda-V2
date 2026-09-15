<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Enums\Locale;
use Enums\SessionKey;
use Exception;
use Http\Controller;
use Http\Models\Legal;
use Http\Requests\CRUD\Legal\UpdateLegalRequest;
use Traits\RequiresAuth;

class LegalController extends Controller
{
    use RequiresAuth;

    public function index(\Base $hive)
    {
        $locale = Locale::normalize($hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value) ?? '');

        $legals = new Legal();
        $legals = $legals->find(
            ['locale=?', $locale],
            ['order' => 'created_at DESC']
        );

        view('pages/admin/legals/index', [
            'title' => 'All legals',
            'legals' => $legals,
        ]);
    }

    public function edit(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $legal = new Legal();
        $legal->load(['id = ?', $id]);

        view('pages/admin/legals/edit', [
            'title' => $hive->get('admin.legal'),
            'legal' => $legal,
        ]);
    }

    public function show(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $legal = new Legal();
        $legal->load(['id = ?', $id]);

        view('pages/admin/legals/show', [
            'title' => $hive->get('admin.legal'),
            'legal' => $legal,
        ]);
    }

    public function update(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $request = $this->request(UpdateLegalRequest::class);
        $request->validate();

        $legal = new Legal();
        $legal->load(['id = ?', $id]);

        if ($legal->dry()) {
            throw new Exception('Legal not found');
        }

        $legal->copyFrom($request->all());
        $legal->save();

        notify($hive->get('admin.legal_successfully_updated'));

        $hive->reroute("@admin_legals_edit(@id=$id)");
    }
}
