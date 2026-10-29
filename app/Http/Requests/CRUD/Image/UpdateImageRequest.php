<?php

namespace Http\Requests\CRUD\Image;

use Http\Request;

class UpdateImageRequest extends Request
{
    public function rules(): array
    {
        return [
            'alt' => [
                'filter' => 'trim|escape_tags',
                'validate' => 'max_len:300',
            ],
            'src' => [
                'filter'   => 'file',
                'validate' => 'image:webp,jpg,jpeg,png|max_size:8800',
                'post_filter'   => 'file:image',
            ]
        ];
    }

    protected function prepare_data(): array
    {
        return array_merge(['alt' => ''], $this->data);
    }

    public function on_failure(): void
    {
        set_values([
            'alt'  => $this->hive->POST['alt'] ?? '',
        ]);

        $referer = $this->hive->HEADERS['Referer'] ?? '/';
        $this->hive->reroute($referer);
    }
}
