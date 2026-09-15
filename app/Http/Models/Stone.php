<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;
use Enums\ImageableType;
use Enums\Locale;

class Stone extends Cortex
{
    function __construct()
    {
        parent::__construct();

        $this->beforeerase(function ($self) {
            if ($self->preview) {
                $self->preview->erase();
            }
            if ($self->image) {
                $self->image->erase();
            }
        });


        $this->onget('preview', function ($self) {
            $img = new Image();
            $img->load([
                'imageable_type = ? AND imageable_id = ? AND variant = ?',
                ImageableType::STONE->value,
                $self->id,
                'preview'
            ]);

            if ($img->dry()) {
                return null;
            }

            return $img;
        });

        $this->onget('image', function ($self) {
            $img = new Image();
            $img->load([
                'imageable_type = ? AND imageable_id = ? AND variant = ?',
                ImageableType::STONE->value,
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
        'name' => [
            'type' => Schema::DT_VARCHAR256,
            'nullable' => false,
        ],
        'html' => [
            'type' => Schema::DT_TEXT,
            'nullable' => false,
        ],
        'locale' => [
            'type' => Schema::DT_VARCHAR128,
            'default' => Locale::RUSSIAN->value,
            'nullable' => false,
        ],
        'created_at' => [
            'type' => Schema::DT_DATE,
            'nullable' => false,
            'default' => Schema::DF_CURRENT_TIMESTAMP,
        ],
    ];

    protected $db = 'DB', $table = 'stones';
}
