<?php

namespace Http\Requests\Card;

use Http\Request;

class StoreCardRequest extends Request
{
    public function rules(): array
    {
        return [
            'title' => [
                'filter'   => 'trim|escape_tags',
                'validate' => 'required|max_len:230',
            ],
            'summary' => [
                'filter'   => 'trim|trim_spaces|escape_tags',
                'validate' => 'required|max_len:4500',
            ],
            'body' => [
                'filter'   => 'trim',
                'validate' => 'required|max_len:42000|no_tags',
            ],
            'created_at' => [
                'validate' => 'required|date',
            ],
            // 'alt' => [
            //     'filter'   => 'trim',
            //     'validate' => 'required|max_len:250',
            // ],
            'preview' => [
                'filter'   => 'file',
                'validate' => 'required|image:webp,jpg,jpeg,png|max_size:8800',
                'post_filter'   => 'file:card',
            ],
            'gallery' => [
                'filter'   => 'file',
                'validate' => 'image:webp,jpg,jpeg,png|max_size:8800',
                'post_filter'   => 'file:card',
            ],
        ];
    }

    protected function prepare_data(): array
    {
        return array_merge($this->data, ['alt' => 'example']);
    }

    protected function on_failure(): void
    {
        set_values([
            'title'    => $this->hive->POST['title'] ?? '',
            'summary' => $this->hive->POST['summary'] ?? '',
            'body'     => $this->hive->POST['body'] ?? '',
            'created_at'     => $this->hive->POST['created_at'] ?? '',
        ]);

        $this->hive->reroute('@admin_cards_create');
    }
}
