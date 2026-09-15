<?php

namespace Http\Requests\CRUD\Iching;

use Http\Request;

class UpdateIchingRequest extends Request
{
    public function rules(): array
    {
        return [
            'description' => [
                'filter'   => 'trim|trim_spaces|strip_tags',
                'validate' => 'max_len:3200',
            ],
        ];
    }

    protected function on_failure(): void
    {
        set_values([
            'description' => $this->hive->POST['description'] ?? '',
        ]);

        $this->hive->reroute('@admin_ichings_edit');
    }
}
