<?php

namespace Http\Models;

use DB\Cortex;
use DB\SQL\Schema;

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
    ];
    protected $db = 'DB', $table = 'users';

    public function set_password($value) {
        return password_hash($value, PASSWORD_DEFAULT);
    }
}
