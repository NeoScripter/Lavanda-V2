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
        'gender' => [
            'type' => Schema::DT_VARCHAR128,
            'nullable' => true,
        ],
        'birthday' => [
            'type' => Schema::DT_DATE,
            'nullable' => true,
        ],
        'role' => [
            'type' => Schema::DT_INT,
            'nullable' => false,
            'default' => UserRole::USER->value,
        ],
    ];
    protected $db = 'DB', $table = 'users';

    public function set_password(string $value) {
        return password_hash($value, PASSWORD_DEFAULT);
    }
}
