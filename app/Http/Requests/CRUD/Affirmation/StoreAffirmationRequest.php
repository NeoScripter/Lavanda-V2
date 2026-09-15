<?php

namespace Http\Requests\CRUD\Affirmation;

use Http\Request;

class StoreAffirmationRequest extends Request
{
    public function rules(): array
    {
        return [
            'quote' => [
                'filter'   => 'trim|escape_tags',
                'validate' => 'required|max_len:1330',
            ],
            'topic' => [
                'filter'   => 'trim|escape_tags',
                'validate' => 'required|max_len:80',
            ]
        ];
    }

    protected function on_failure(): void
    {
        set_values([
            'quote'    => $this->hive->POST['quote'] ?? '',
            'topic' => $this->hive->POST['topic'] ?? '',
        ]);

        $this->hive->reroute('@admin_affirmations_create');
    }
}
