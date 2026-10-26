<?php

namespace Http\Requests\Profile;

use Http\Request;

class PasswordResetSendRequest extends Request
{
    public function rules(): array
    {
        return [
            'email' => [
                'filter' => 'trim|lowercase|sanitize_email',
                'validate' => 'required|max_len:200|email',
            ]
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

        $this->hive->reroute("@password_reset_index");
    }
}
