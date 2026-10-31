<?php

namespace Http\Requests\Web;

use Http\Request;

class ConsultationRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => [
                'filter' => 'trim|capitalize',
                'validate' => 'required|max_len:200',
            ],
            'email' => [
                'filter' => 'trim|lowercase|sanitize_email',
                'validate' => 'required|max_len:200|email|unique:users,email',
            ],
            'message' => [
                'filter' => 'trim',
                'validate' => 'required|min_len:8|max_len:5000'
            ],
            'emphasis' => [
                'filter' => 'trim',
                'validate' => 'max_len:5000',
            ],
            'other' => [
                'filter' => 'trim',
                'validate' => 'max_len:5000',
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
            'name' => $this->hive->POST['name'] ?? '',
            'email' => $this->hive->POST['email'] ?? '',
            'message' => $this->hive->POST['message'] ?? '',
            'priority' => $this->hive->POST['priority'] ?? '',
            'details' => $this->hive->POST['details'] ?? '',
        ]);

        $this->hive->reroute('@consultation');
    }
}
