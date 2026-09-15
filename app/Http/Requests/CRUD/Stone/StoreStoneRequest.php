<?php

namespace Http\Requests\CRUD\Stone;

use Enums\SessionKey;
use Http\Request;

class StoreStoneRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => [
                'filter'   => 'trim|escape_tags',
                'validate' => 'required|max_len:230',
            ],
            'html' => [
                'filter'   => 'trim|trim_spaces',
                'validate' => 'requied|max_len:42000|no_tags',
            ],
            'preview' => [
                'filter'   => 'file',
                'validate' => 'required|image:webp,jpg,jpeg,png|max_size:8800',
                'post_filter'   => 'file:stone',
            ],
            'image' => [
                'filter'   => 'file',
                'validate' => 'required|image:webp,jpg,jpeg,png|max_size:8800',
                'post_filter'   => 'file:stone',
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
            'name'    => $this->hive->POST['name'] ?? '',
            'html' => $this->hive->POST['html'] ?? '',
        ]);

        $this->hive->reroute('@admin_stones_create');
    }
}
