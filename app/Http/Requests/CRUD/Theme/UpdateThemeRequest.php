<?php

namespace Http\Requests\CRUD\Theme;

use Http\Request;

class UpdateThemeRequest extends Request
{
    public function rules(): array
    {
        return [
            'html' => [
                'filter'   => 'trim',
                'validate' => 'required|max_len:42000|no_tags',
            ],
        ];
    }

    protected function on_failure(): void
    {
        set_values([
            'html' => $this->hive->POST['html'] ?? '',
        ]);

        $referrer = $this->hive->HEADERS['Referer'] ?? '/';
        $this->hive->reroute($referrer);
    }
}
