<?php

namespace Http\Requests\CRUD\Legal;

use Enums\SessionKey;
use Http\Request;

class UpdateLegalRequest extends Request
{
    public function rules(): array
    {
        return [
            'html' => [
                'filter'   => 'trim',
                'validate' => 'required|max_len:42000|no_tags',
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
            'html' => $this->hive->POST['html'] ?? '',
        ]);

        $this->hive->reroute('@admin_articles_edit');
    }
}
