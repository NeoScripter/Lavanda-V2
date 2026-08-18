<?php

namespace Http\Requests\Profile;

use Http\Request;

class UpdateLocaleRequest extends Request
{
    public function rules(): array
    {
        return [
            'locale' => [
                'filter' => 'trim',
                'validate' => 'required|max_len:200',
            ],
        ];
    }

    protected function prepare_data(): array
    {
        return $this->data;
    }

    protected function on_failure(): void
    {
        set_values([
            'locale'  => $this->hive->POST['locale'] ?? '',
        ]);

        $this->hive->reroute('@locale');
    }
}
