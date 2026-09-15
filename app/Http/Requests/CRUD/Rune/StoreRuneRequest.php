<?php

namespace Http\Requests\CRUD\Rune;

use Enums\SessionKey;
use Http\Request;

class StoreRuneRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => [
                'filter'   => 'trim|escape_tags',
                'validate' => 'required|max_len:130',
            ],
            'advice' => [
                'filter'   => 'trim|trim_spaces|strip_tags',
                'validate' => 'required|max_len:1200',
            ],
            'front_image' => [
                'filter'   => 'file',
                'validate' => 'required|image:webp,jpg,jpeg,png|max_size:8800',
                'post_filter'   => 'file:rune-image',
            ],
            'back_image' => [
                'filter'   => 'file',
                'validate' => 'required|image:webp,jpg,jpeg,png|max_size:8800',
                'post_filter'   => 'file:rune-image',
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
            'advice' => $this->hive->POST['advice'] ?? '',
        ]);

        $this->hive->reroute('@admin_runes_create');
    }
}
