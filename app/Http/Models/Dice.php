<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;
use Enums\Locale;
use Enums\ThemeableType;
use InvalidArgumentException;

class Dice extends Cortex
{
    function __construct()
    {
        parent::__construct();

        $this->beforeerase(function ($self) {
            $db = \Base::instance()->get('DB');

            $db->exec(
                "DELETE FROM themes WHERE themeable_type = ? AND themeable_id = ?",
                [$self->variant, $self->id]
            );
        });

        $this->beforeinsert(function ($self) {
            $db = \Base::instance()->get('DB');

            $res = $db->exec(
                "SELECT EXISTS 
                    (SELECT 1 FROM dices WHERE diceable_id = ? AND locale = ?) 
                AS exists",
                [$self->diceable_id, $self->locale]
            );

            if ($res[0]['exists']) {
                throw new InvalidArgumentException('This dice combination already exists');
            }
        });

        $this->afterinsert(function ($self) {
            $db = \Base::instance()->get('DB');

            $res = $db->exec(
                "SELECT EXISTS ( SELECT 1 FROM themes WHERE themeable_type = ? AND themeable_id = ?) AS exists",
                [ThemeableType::DICE->value, $self->id]
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
                    'themeable_type' => $self->variant,
                    'name' => $theme_name,
                    'html' => 'placeholder',
                ]);
                $theme->save();
            }
        });


        $this->onget('themes', function ($self) {
            $themes = new Theme();

            return $themes->find([
                'themeable_type = ? AND themeable_id = ?',
                ThemeableType::DICE->value,
                $self->id,
            ], ['order' => 'name']);
        });
    }

    protected $fieldConf = [
        'diceable_id' => [
            'type' => Schema::DT_VARCHAR128,
            'nullable' => false,
            'index' => true,
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

    protected $db = 'DB', $table = 'dices';
}
