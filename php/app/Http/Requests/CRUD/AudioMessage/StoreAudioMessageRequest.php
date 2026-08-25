<?php

namespace Http\Requests\CRUD\AudioMessage;

use Enums\SessionKey;
use Http\Request;

class StoreAudioMessageRequest extends Request
{
    public function rules(): array
    {
        return [
            'description' => [
                'filter'   => 'trim|trim_spaces|strip_tags',
                'validate' => 'required|max_len:1200',
            ],
            'file' => [
                'filter'   => 'file',
                'validate' => 'required|max_size:8800|file:3dm,skp,mp3,mpa',
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
            'description' => $this->hive->POST['description'] ?? '',
        ]);

        $this->hive->reroute('@admin_audio_messages_create');
    }
}
