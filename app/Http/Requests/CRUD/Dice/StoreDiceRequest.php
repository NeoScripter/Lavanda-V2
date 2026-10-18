<?php

namespace Http\Requests\CRUD\Dice;

use Enums\SessionKey;
use Http\Request;

class StoreDiceRequest extends Request
{
    public function rules(): array
    {
        return [
            'diceable_id' => [
                'filter' => 'trim',
                'validate' => 'required|min_len:1|unique:dices,diceable_id',
            ],
            'locale' => [
                'filter'   => 'trim',
            ],
        ];
    }

    protected function prepare_data(): array
    {
        return array_merge($this->data, [
            'locale' => $this->hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value),
        ]);
    }

    protected function on_failure(): void
    {
        set_values([
            'diceable_id' => $this->hive->POST['diceable_id'] ?? '',
        ]);

        $this->hive->reroute('@admin_dices_create');
    }
}
