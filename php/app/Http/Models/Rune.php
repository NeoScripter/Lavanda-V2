<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;
use Enums\ImageableType;
use Enums\Locale;

class Rune extends Cortex
{
    function __construct()
    {
        parent::__construct();

        $this->beforeerase(function ($self) {
            if ($self->front_image) {
                $self->front_image->erase();
            }
            if ($self->back_image) {
                $self->back_image->erase();
            }
            foreach ($self->themes as $theme) {
                $theme->erase();
            }
        });

        $this->onget('front_image', function ($self) {
            $img = new Image();
            $img->load([
                'imageable_type = ? AND imageable_id = ? AND variant = ?',
                ImageableType::RUNE->value,
                $self->id,
                'front_image'
            ]);

            if ($img->dry()) {
                return null;
            }

            return $img;
        });

        $this->onget('back_image', function ($self) {
            $img = new Image();
            $img->load([
                'imageable_type = ? AND imageable_id = ? AND variant = ?',
                ImageableType::RUNE->value,
                $self->id,
                'back_image'
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
        'advice' => [
            'type' => Schema::DT_TEXT,
            'nullable' => false,
        ],
        'themes' => [
            'has-many' => ['\Http\Models\RuneTheme', 'rune']
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

    protected $db = 'DB', $table = 'runes';
}
