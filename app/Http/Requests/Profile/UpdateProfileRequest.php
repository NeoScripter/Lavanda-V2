<?php

namespace Http\Requests\Profile;

use Enums\UserRole;
use Http\Request;
use Support\Auth;

class UpdateProfileRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => [
                'filter' => 'trim|escape_tags',
                'validate' => 'required|max_len:200',
            ],
            'email' => [
                'filter' => 'trim|lowercase|sanitize_email',
                'validate' => 'required|email|max_len:200|unique:users,email*' . $this->hive->POST['email'],
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
            'name'  => $this->hive->POST['name']            ?? '',
            'email' => $this->hive->POST['email']           ?? '',
        ]);

        $user = Auth::user();
        $redirect_route = $user['role'] === UserRole::ADMIN->value ? '@admin_profile' : '@profile';
        $this->hive->reroute($redirect_route);
    }
}
