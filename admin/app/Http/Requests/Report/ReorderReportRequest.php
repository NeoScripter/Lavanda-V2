<?php

namespace Http\Requests\Report;

use Http\Request;

class ReorderReportRequest extends Request
{
    public function rules(): array
    {
        return [
            'target_id' => [
                'filter'   => 'trim',
                'validate' => 'required|numeric|exists:reports,id',
            ],
            'dragged_id' => [
                'filter'   => 'trim',
                'validate' => 'required|numeric|exists:reports,id',
            ],
        ];
    }

    protected function prepare_data(): array
    {
        return $this->data;
    }

    protected function on_failure(): void
    {
        $this->hive->reroute('@admin_reports_index');
    }
}
