<?php

namespace Http\Requests\CRUD\MatchSet;

use Enums\SessionKey;
use Http\Request;

class StoreMatchSetRequest extends Request
{
    public function rules(): array
    {
        return [
            'ids' => [
                'filter'   => 'trim',
            ],
            'advice' => [
                'filter'   => 'trim|trim_spaces|strip_tags',
                'validate' => 'required|max_len:1200',
            ],
            'html' => [
                'filter'   => 'trim',
                'validate' => 'required|max_len:42000|no_tags',
            ],
            'matcheable_type' => [
                'filter'   => 'trim',
                'validate' => 'required',
            ],
            'matcheable_id' => [
                'filter'   => 'trim|min_len:1',
                'validate' => 'required',
            ],
        ];
    }

    protected function prepare_data(): array
    {
        return array_merge($this->data, [
            'locale' => $this->hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value),
            'matcheable_type' => $this->hive->get('SESSION.' . SessionKey::MATCHEABLE_TYPE->value),
        ]);
    }

    protected function on_failure(): void
    {
        set_values([
            'html' => $this->hive->POST['html'] ?? '',
            'advice' => $this->hive->POST['advice'] ?? '',
        ]);

        $this->hive->reroute('@admin_match_sets_index');
    }
}
