<?php

namespace Http\Requests\Profile;

use Http\Request;

class UpdateProgramRequest extends Request
{
    public function rules(): array
    {
        return [
            'gallery' => [
                'filter'   => 'file',
                'validate' => 'image:webp,jpg,jpeg,png|max_size:8800',
                'post_filter'   => 'file:programs',
            ],
        ];
    }

    protected function prepare_data(): array
    {
        return array_merge($this->data, ['alt' => 'example']);
    }

    protected function on_failure(): void
    {
        $this->hive->reroute('@admin_programs_edit');
    }
}
