<?php

namespace Http\Requests\CRUD\Affirmation;

use Http\Request;

class UpdateAffirmationRequest extends Request
{
    public function rules(): array
    {
        return [
            'quote' => [
                'filter'   => 'trim|escape_tags',
                'validate' => 'max_len:1300',
            ],
            'topic' => [
                'filter'   => 'trim|escape_tags',
                'validate' => 'max_len:80',
            ],
        ];
    }

    protected function on_failure(): void
    {
        set_values([
            'quote'    => $this->hive->POST['quote'] ?? '',
            'topic' => $this->hive->POST['topic'] ?? '',
        ]);

        $this->hive->reroute('@admin_affirmations_edit');
    }
}
