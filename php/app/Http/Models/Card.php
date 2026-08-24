<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;
use Enums\Locale;

class Card extends Cortex
{
    function __construct()
    {
        parent::__construct();

        $this->beforeerase(function ($self) {
            if ($self->front_image) {
                $self->front_image->erase();
            }
        });

        $this->onget('front_image', function ($self) {
            $img = new Image();
            $img->load([
                'imageable_type = ? AND imageable_id = ? AND variant = ?',
                $self->variant,
                $self->id,
                'front_image'
            ]);

            if ($img->dry()) {
                return null;
            }

            return $img;
        });
    }

    protected $fieldConf = [
        'name' => [
            'type' => Schema::DT_VARCHAR256,
            'nullable' => false,
        ],
        'html' => [
            'type' => Schema::DT_TEXT,
            'nullable' => false,
        ],
        'advice' => [
            'type' => Schema::DT_TEXT,
            'nullable' => false,
        ],
        'variant' => [
            'type' => Schema::DT_VARCHAR128,
            'nullable' => false,
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

    protected $db = 'DB', $table = 'cards';
}
