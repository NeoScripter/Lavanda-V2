<?php

namespace Http\Requests\Report;

use Http\Request;

class UpdateReportRequest extends Request
{
    public function rules(): array
    {
        return [
            'title' => [
                'filter'   => 'trim|escape_tags',
                'validate' => 'required|max_len:230',
            ],
            'src' => [
                'filter'   => 'file',
                'validate' => 'max_size:8800|file:pdf,docx,doc,jpg,jpeg,png,webp',
                'post_filter'   => 'file:report',
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
            'title' => $this->hive->POST['title'] ?? '',
        ]);

        $this->hive->reroute('@admin_reports_edit');
    }
}
