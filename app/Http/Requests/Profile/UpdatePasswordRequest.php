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
            'password' => [
                'filter' => 'trim',
                'validate' => 'required|min_len:8|diff:current_password',
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
        $referer = $hive->HEADERS['Referer'] ?? '/';
        $this->hive->reroute($referer);
    }
}
