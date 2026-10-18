<?php

namespace Http\Requests\CRUD\Dice;

use Enums\SessionKey;
use Http\Request;

class UpdateDiceRequest extends Request
{
    public function rules(): array
    {
        return [
            'diceable_id' => [
                'filter' => 'trim',
                'validate' => 'required|min_len:1|unique:dices,diceable_id*'. $this->hive->POST['diceable_id'],
            ]
        ];
    }

    protected function prepare_data(): array
    {
        return array_merge($this->data, [
            'locale' => $this->hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value),
        ]);
    }

    public function on_failure(): void
    {
        set_values([
            'diceable_id' => $this->hive->POST['diceable_id'] ?? '',
        ]);

        $this->hive->reroute('@admin_match_sets_edit');
    }
}
