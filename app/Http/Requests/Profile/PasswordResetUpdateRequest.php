<?php

namespace Http\Requests\Profile;

use Http\Request;

class PasswordResetUpdateRequest extends Request
{
    public function rules(): array
    {
        return [
            'signature' => [
                'validate' => 'required',
            ],
            'password' => [
                'filter' => 'trim',
                'validate' => 'required|min_len:8',
            ],
            'password_confirmation' => [
                'filter' => 'trim',
                'validate' => 'required|min_len:8|matches:password',
            ],
        ];
    }

    protected function prepare_data(): array
    {
        return $this->data;
    }

    public function on_failure(): void
    {
        $this->hive->reroute($this->hive->alias(
            "password_reset_edit",
            ['signature' => $this->hive->POST['signature'] ?? null]
        ));
    }
}
