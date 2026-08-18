<?php

namespace Http\Requests\CRUD\FAQ;

use Http\Request;

class StoreFAQRequest extends Request
{
    public function rules(): array
    {
        return [
            'question' => [
                'filter'   => 'trim|escape_tags',
                'validate' => 'required|max_len:330',
            ],
            'answer' => [
                'filter'   => 'trim|trim_spaces|strip_tags',
                'validate' => 'required|max_len:2200',
            ]
        ];
    }

    protected function on_failure(): void
    {
        set_values([
            'question'    => $this->hive->POST['question'] ?? '',
            'answer' => $this->hive->POST['answer'] ?? '',
        ]);

        $this->hive->reroute('@admin_faqs_create');
    }
}
