<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;
use Enums\Locale;

class AudioMessage extends Cortex
{
    function __construct()
    {
        parent::__construct();

        $this->beforeerase(function ($self) {
            if ($self->file) {
                purge_file($self->file);
            }
        });
    }

    protected $fieldConf = [
        'description' => [
            'type' => Schema::DT_TEXT,
            'nullable' => false,
        ],
        'file' => [
            'type' => Schema::DT_VARCHAR256,
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

    protected $db = 'DB', $table = 'audio_messages';
}
