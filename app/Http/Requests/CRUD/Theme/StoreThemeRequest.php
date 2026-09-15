<?php

namespace Http\Requests\CRUD\Theme;

use Http\Request;

class StoreThemeRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => [
                'filter'   => 'trim',
                'validate' => 'required|max_len:200|no_tags',
            ],
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
            'name' => $this->hive->POST['name'] ?? '',
        ]);

        $referrer = $this->hive->HEADERS['Referer'] ?? '/';
        $this->hive->reroute($referrer);
    }
}
