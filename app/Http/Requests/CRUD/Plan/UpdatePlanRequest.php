<?php

namespace Http\Requests\CRUD\Plan;

use Http\Request;

class UpdatePlanRequest extends Request
{
    public function rules(): array
    {
        return [
            'price' => [
                'filter'   => 'trim|escape_tags',
                'validate' => 'numeric|max:1000000',
            ],
            'is_active' => [
                'filter'   => 'boolean',
                'validate' => 'boolean',
            ],
        ];
    }

    public function on_failure(): void
    {
        set_values([
            'price' => $this->hive->POST['price'] ?? '',
            'is_active' => $this->hive->POST['is_active'] ?? '',
        ]);

        $this->hive->reroute('@admin_plans_edit');
    }
}
