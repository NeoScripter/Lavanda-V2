<?php

namespace Http\Requests\CRUD\Article;

use Enums\SessionKey;
use Http\Request;

class UpdateArticleRequest extends Request
{
    public function rules(): array
    {
        return [
            'description' => [
                'filter'   => 'trim|trim_spaces|escape_tags',
                'validate' => 'required|max_len:1200',
            ],
            'html' => [
                'filter'   => 'trim',
                'validate' => 'required|max_len:42000|no_tags',
            ],
            'image' => [
                'filter'   => 'file',
                'validate' => 'image:webp,jpg,jpeg,png|max_size:8800',
                'post_filter'   => 'file:article',
            ],
            'preview' => [
                'filter'   => 'file',
                'validate' => 'image:webp,jpg,jpeg,png|max_size:8800',
                'post_filter'   => 'file:article',
            ],
        ];
    }

    protected function prepare_data(): array
    {
        return array_merge($this->data, [
            'locale' => $this->hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value),
        ]);
    }

    protected function on_failure(): void
    {
        set_values([
            'description' => $this->hive->POST['description'] ?? '',
            'html' => $this->hive->POST['html'] ?? '',
        ]);

        $this->hive->reroute('@admin_articles_edit');
    }
}
