<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Enums\Locale;
use Enums\SessionKey;
use Enums\ThemeableType;
use Exception;
use Http\Controller;
use Http\Models\Dice;
use Http\Requests\CRUD\Dice\StoreDiceRequest;
use Http\Requests\CRUD\Dice\UpdateDiceRequest;
use Traits\RequiresAdminRights;

class DiceController extends Controller
{
    use RequiresAdminRights;

    private string $locale;

    public function __construct()
    {
        $hive = \Base::instance();
        $this->locale = Locale::normalize($hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value) ?? '');
    }

    public function index(\Base $hive)
    {
        $page = $hive->GET['page'] ?? 1;
        $page = is_numeric($page) ? (int) $page : 1;

        $dices = new Dice();
        $dices = $dices->paginate(
            $page - 1,
            15,
            ['locale=?', $this->locale],
            ['order' => 'created_at DESC']
        );

        view('pages/admin/dices/index', [
            'title' => 'All dices',
            'dices' => $dices,
        ]);
    }

    public function create()
    {
        view('pages/admin/dices/create');
    }

    public function edit(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $dice = new Dice();
        $dice->load(['id = ?', $id]);

        view('pages/admin/dices/edit', [
            'title' => 'Dice',
            'dice' => $dice,
            'themes' => get_unique_themes_for_model(ThemeableType::DICE, $id),
        ]);
    }

    public function show(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $dice = new Dice();
        $dice->load(['id = ?', $id]);
        $themes = $dice->themes;


        view('pages/admin/dices/show', [
            'title' => 'Dice',
            'dice' => $dice,
            'themes' => $themes,
        ]);
    }

    public function store(\Base $hive)
    {
        $request = $this->request(StoreDiceRequest::class);
        $locale = $hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value);

        $existing_diceable_ids = array_map(
            fn($arr) => $arr['diceable_id'],
            $hive->get("DB")->exec(
                'SELECT d.diceable_id FROM dices d WHERE d.locale = ?',
                [$locale]
            )
        );

        if (in_array($request->input('diceable_id'), $existing_diceable_ids)) {
            $request->flash_errors(['diceable_id' => 'This combination already exists']);
            $request->on_failure();
        }

        $request->validate();

        $dice = new Dice();
        $dice->copyFrom($request->all());
        $dice->save();

        notify("{$hive->get('admin.dice_successfully_created')}!");

        $hive->reroute('@admin_dices_index');
    }

    public function update(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $request = $this->request(UpdateDiceRequest::class);
        $request->validate();

        $dice = new Dice();
        $dice->load(['id = ?', $id]);

        if ($dice->dry()) {
            throw new Exception('Dice not found');
        }

        $dice->copyFrom($request->all());
        $dice->save();

        notify($hive->get('admin.dice_successfully_updated'));

        $hive->reroute("@admin_dices_edit(@id=$id)");
    }

    public function destroy(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $dice = new Dice();
        $dice->load(['id = ?', $id]);
        $dice->erase();

        notify($hive->get('admin.dice_successfully_deleted'));
        $hive->reroute("@admin_dices_index");
    }
}
