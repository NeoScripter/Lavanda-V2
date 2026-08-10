<?php

namespace Http\Requests\Article;

use Http\Request;

class StoreArticleRequest extends Request
{
    public function rules(): array
    {
        return [
            'title' => [
                'filter'   => 'trim|escape_tags',
                'validate' => 'required|max_len:230',
            ],
            'url' => [
                'filter'   => 'trim',
                'validate' => 'required|max_len:120|url',
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
                'post_filter'   => 'file:articles',
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
            'url' => $this->hive->POST['url'] ?? '',
        ]);

        $this->hive->reroute('@admin_articles_create');
    }
}
