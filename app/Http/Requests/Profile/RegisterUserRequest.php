<?php

namespace Http\Requests\Profile;

use Http\Request;

class RegisterUserRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => [
                'filter' => 'trim',
                'validate' => 'required|max_len:200',
            ],
            'email' => [
                'filter' => 'trim|lowercase|sanitize_email',
                'validate' => 'required|max_len:200|email|unique:users,email',
            ],
            'password' => [
                'filter' => 'trim',
                'validate' => 'required|min_len:8'
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
        set_values([
            'name' => $this->hive->POST['name'] ?? '',
            'email' => $this->hive->POST['email'] ?? '',
        ]);

        $referrer = $hive->HEADERS['Referer'] ?? '@register';
        $this->hive->reroute($referrer);
    }
}
