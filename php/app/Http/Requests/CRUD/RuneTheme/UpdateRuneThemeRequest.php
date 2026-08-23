<?php

namespace Http\Requests\CRUD\RuneTheme;

use Http\Request;

class UpdateRuneThemeRequest extends Request
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

        $this->hive->reroute('@admin_rune_theme_edit');
    }
}
