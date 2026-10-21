<?php

namespace Http\Requests\Profile;

use Enums\UserRole;
use Http\Request;
use Support\Auth;

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

        $user = Auth::user();

        $redirect_route = (!empty($user) && $user['role'] === UserRole::ADMIN->value) ? '@admin_login' : '@login';
        $this->hive->reroute($redirect_route);
    }
}
