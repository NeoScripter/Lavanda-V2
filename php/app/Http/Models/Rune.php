<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;
use Enums\ImageableType;
use Enums\Locale;
use Enums\ThemeableType;

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

            $db = \Base::instance()->get('DB');

            $db->exec(
                "DELETE FROM themes WHERE themeable_type = ? AND themeable_id = ?",
                [ThemeableType::RUNE->value, $self->id]
            );
        });

        $this->afterinsert(function ($self) {
            $db = \Base::instance()->get('DB');

            $res = $db->exec(
                "SELECT EXISTS ( SELECT 1 FROM themes WHERE themeable_type = ? AND themeable_id = ?) AS exists",
                [ThemeableType::RUNE->value, $self->id]
            );

            $theme_name = match ($self->locale) {
                Locale::GERMAN->value => 'Allgemein',
                Locale::RUSSIAN->value => 'Общая',
                Locale::SERBIAN->value => 'Opšte',
                default => 'General'
            };

            if (empty($res[0]['exists'])) {
                $theme = new Theme();
                $theme->copyfrom([
                    'themeable_id' => $self->id,
                    'themeable_type' => ThemeableType::RUNE->value,
                    'name' => $theme_name,
                    'html' => 'placeholder',
                ]);
                $theme->save();
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

        $this->onget('themes', function ($self) {
            $themes = new Theme();

            return $themes->find([
                'themeable_type = ? AND themeable_id = ?',
                ThemeableType::RUNE->value,
                $self->id,
            ], ['order' => 'name']);
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
