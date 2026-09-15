<?php

namespace Http\Requests\CRUD\Card;

use Enums\SessionKey;
use Http\Request;

class StoreCardRequest extends Request
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
            'description' => [
                'filter'   => 'trim|strip_tags',
                'validate' => 'required|max_len:42000',
            ],
            'variant' => [
                'filter'   => 'trim',
                'validate' => 'required',
            ],
            'front_image' => [
                'filter'   => 'file',
                'validate' => 'required|image:webp,jpg,jpeg,png|max_size:8800',
                'post_filter'   => 'file:card-' . $this->input('variant'),
            ],
        ];
    }

    protected function prepare_data(): array
    {
        return array_merge($this->data, [
            'locale' => $this->hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value),
            'variant' => $this->hive->get('SESSION.' . SessionKey::CARD_VARIANT->value)
        ]);
    }

    protected function on_failure(): void
    {
        set_values([
            'name'    => $this->hive->POST['name'] ?? '',
            'advice' => $this->hive->POST['advice'] ?? '',
            'description'     => $this->hive->POST['description'] ?? '',
        ]);

        $this->hive->reroute('@admin_cards_create');
    }
}
