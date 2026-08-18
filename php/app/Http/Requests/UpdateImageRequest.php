<?php

namespace Http\Requests;

use Http\Request;

class UpdateImageRequest extends Request
{
    public function rules(): array
    {
        return [
            'alt' => [
                'filter' => 'trim|escape_tags',
                'validate' => 'required|max_len:300',
            ],
            'src' => [
                'filter'   => 'file',
                'validate' => 'image:webp,jpg,jpeg,png|max_size:8800',
                'post_filter'   => 'file:image',
            ],
            'sizes' => [
                'validate' => 'required|array'
            ]
        ];
    }

    protected function prepare_data(): array
    {
        return $this->data;
    }

    protected function on_failure(): void
    {
        set_values([
            'alt'  => $this->hive->POST['alt'] ?? '',
        ]);

        $referrer = $this->hive->HEADERS['Referer'] ?? '/';
        $this->hive->reroute($referrer);
    }
}
