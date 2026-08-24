<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;
use Enums\ImageableType;
use Enums\Locale;

class PracticeItem extends Cortex
{
    function __construct()
    {
        parent::__construct();

        $this->beforeerase(function ($self) {
            if ($self->image) {
                $self->image->erase();
            }
        });

        $this->onget('image', function ($self) {
            $img = new Image();
            $img->load([
                'imageable_type = ? AND imageable_id = ? AND variant = ?',
                ImageableType::PRACTICE_ITEM->value,
                $self->id,
                'image'
            ]);

            if ($img->dry()) {
                return null;
            }

            return $img;
        });
    }

    protected $fieldConf = [
        'title' => [
            'type' => Schema::DT_VARCHAR256,
            'nullable' => false,
        ],
        'file_src' => [
            'type' => Schema::DT_VARCHAR256,
        ],
        'description' => [
            'type' => Schema::DT_TEXT,
            'nullable' => false,
        ],
        'faqs' => [
            'type' => Schema::DT_TEXT,
        ],
        'locale' => [
            'type' => Schema::DT_VARCHAR128,
            'default' => Locale::ENGLISH->value,
            'nullable' => false,
        ],
        'created_at' => [
            'type' => Schema::DT_DATE,
            'nullable' => false,
            'default' => Schema::DF_CURRENT_TIMESTAMP,
        ],
    ];

    protected $db = 'DB', $table = 'practice_items';

    public function get_faqs(?string $faqs): ?array
    {
        if (empty($faqs)) {
            return null;
        }

        $decoded = json_decode($faqs, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        if (!is_array($decoded)) {
            return null;
        }

        foreach ($decoded as $item) {
            if (!isset($item['question'], $item['answer'])) {
                return null;
            }
        }

        return $decoded;
    }

    public function set_faqs(?array $value): ?string
    {
        if (empty($value)) {
            return null;
        }

        foreach ($value as $item) {
            if (!isset($item['question'], $item['answer'])) {
                return null;
            }
        }

        $encoded = json_encode($value);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        return $encoded;
    }
}
