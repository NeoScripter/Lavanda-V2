<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Enums\Locale;
use Enums\SessionKey;
use Exception;
use Http\Controller;
use Http\Models\Iching;
use Http\Requests\CRUD\Iching\UpdateIchingRequest;
use Traits\RequiresAuth;

class IchingController extends Controller
{
    use RequiresAuth;

    public function index(\Base $hive)
    {
        $locale = Locale::normalize($hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value) ?? '');

        $ichings = new Iching();
        $ichings = $ichings->find(
            ['locale=?', $locale],
            ['order' => 'created_at DESC']
        );

        view('pages/admin/ichings/index', [
            'title' => 'All ichings',
            'ichings' => $ichings,
        ]);
    }

    public function edit(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $iching = new Iching();
        $iching->load(['id = ?', $id]);

        view('pages/admin/ichings/edit', [
            'title' => 'Ichings',
            'iching' => $iching,
        ]);
    }

    public function update(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $request = $this->request(UpdateIchingRequest::class);
        $request->validate();

        $iching = new Iching();
        $iching->load(['id = ?', $id]);

        if ($iching->dry()) {
            throw new Exception('Iching not found');
        }

        $iching->copyFrom($request->all());
        $iching->save();

        notify($hive->get('admin.iching_successfully_updated'));

        $hive->reroute("@admin_ichings_edit(@id=$id)");
    }
}
