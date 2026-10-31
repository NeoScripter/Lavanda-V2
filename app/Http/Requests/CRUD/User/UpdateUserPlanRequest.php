<?php

namespace Http\Requests\CRUD\User;

use Http\Request;

class UpdateUserPlanRequest extends Request
{
    public function rules(): array
    {
        return [
            'plan' => [
                'filter'   => 'trim|escape_tags',
                'validate' => 'in:abs,1,2',
            ]
        ];
    }

    public function on_failure(): void
    {
        $this->hive->reroute('@admin_users_edit', ['id' => $this->hive->PARAMS['id']]);
    }
}
