<?php

namespace Http\Requests\Profile;

use Http\Request;

class UpdatePasswordRequest extends Request
{
    public function rules(): array
    {
        return [
            'current_password' => [
                'filter' => 'trim',
                'validate' => 'required|min_len:8',
            ],
            'new_password' => [
                'filter' => 'trim',
                'validate' => 'required|min_len:8|diff:current_password',
            ],
            'password_confirmation' => [
                'filter' => 'trim',
                'validate' => 'required|min_len:8|matches:new_password',
            ],
        ];
    }

    protected function prepare_data(): array
    {
        return $this->data;
    }

    protected function on_failure(): void
    {
        $this->hive->reroute('@password');
    }
}
