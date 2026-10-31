<?php

namespace Http\Requests\Profile;

use Http\Request;

class LoginRequest extends Request
{
    public function rules(): array
    {
        return [
            'email' => [
                'filter' => 'trim|lowercase|sanitize_email',
                'validate' => 'required|max_len:200|email|exists:users,email',
            ],
            'password' => [
                'filter' => 'trim',
                'validate' => 'required'
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
            'email' => $this->hive->POST['email'] ?? '',
        ]);

        $redirect_route = $this->hive->POST['redirect_to'] ?? '@login';
        $this->hive->reroute($redirect_route);
    }
}
