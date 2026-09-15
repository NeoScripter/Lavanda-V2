<?php

namespace Http\Requests\CRUD\FAQ;

use Http\Request;

class UpdateFAQRequest extends Request
{
    public function rules(): array
    {
        return [
            'question' => [
                'filter'   => 'trim|escape_tags',
                'validate' => 'max_len:330',
            ],
            'answer' => [
                'filter'   => 'trim|trim_spaces|strip_tags',
                'validate' => 'max_len:2200',
            ],
        ];
    }

    protected function on_failure(): void
    {
        set_values([
            'question'    => $this->hive->POST['question'] ?? '',
            'answer' => $this->hive->POST['answer'] ?? '',
        ]);

        $this->hive->reroute('@admin_faqs_edit');
    }
}
