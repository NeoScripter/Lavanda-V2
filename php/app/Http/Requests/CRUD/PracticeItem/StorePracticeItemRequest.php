<?php

namespace Http\Requests\CRUD\PracticeItem;

use Enums\SessionKey;
use Http\Request;

class StorePracticeItemRequest extends Request
{
    public function rules(): array
    {
        return [
            'title' => [
                'filter'   => 'trim|escape_tags',
                'validate' => 'required|max_len:230',
            ],
            'description' => [
                'filter'   => 'trim|trim_spaces|strip_tags',
                'validate' => 'required|max_len:1200',
            ],
            'file_src' => [
                'filter'   => 'file',
                'validate' => 'required|max_size:8800|file:pdf,docx,doc,jpg,jpeg,png,webp',
                'post_filter'   => 'file:practice_item',
            ],
            'image' => [
                'filter'   => 'file',
                'validate' => 'required|image:webp,jpg,jpeg,png|max_size:8800',
                'post_filter'   => 'file:practice_item',
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
            'title'    => $this->hive->POST['title'] ?? '',
            'description' => $this->hive->POST['description'] ?? '',
        ]);

        $this->hive->reroute('@admin_practice_items_create');
    }
}
