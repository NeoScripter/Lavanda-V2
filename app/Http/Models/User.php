<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;
use Enums\UserRole;

class User extends Cortex
{
    protected $fieldConf = [
        'name' => [
            'type' => Schema::DT_VARCHAR256,
            'nullable' => false,
        ],
        'email' => [
            'type' => Schema::DT_VARCHAR128,
            'index' => true,
            'unique' => true,
            'nullable' => false,
        ],
        'password' => [
            'type' => Schema::DT_TEXT,
            'nullable' => false,
        ],
        'is_deleted' => [
            'type' => Schema::DT_BOOLEAN,
            'nullable' => false,
            'default' => false,
        ],
        'yandex_id' => [
            'type' => Schema::DT_VARCHAR128,
            'unique' => true,
            'nullable' => true,
        ],
        'google_id' => [
            'type' => Schema::DT_VARCHAR128,
            'unique' => true,
            'nullable' => true,
        ],
        'subscription' => [
            'has-one' => ["\Http\Models\Subscription", "user"]
        ],
        'consultation' => [
            'has-one' => ["\Http\Models\Consultation", "user"]
        ],
        'game' => [
            'has-one' => ["\Http\Models\Game", "user"]
        ],
        'role' => [
            'type' => Schema::DT_INT,
            'nullable' => false,
            'default' => UserRole::USER->value,
        ],
        'created_at' => [
            'type' => Schema::DT_DATE,
            'nullable' => false,
            'default' => Schema::DF_CURRENT_TIMESTAMP,
        ],
    ];
    protected $db = 'DB', $table = 'users';

    public function set_password(string $value)
    {
        return password_hash($value, PASSWORD_DEFAULT);
    }
}
