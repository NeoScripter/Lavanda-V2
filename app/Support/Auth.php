<?php

declare(strict_types=1);

namespace Support;

use DB\SQL\Mapper;
use Http\Models\User;
use InvalidArgumentException;

const CACHE_TTL_SECONDS = 60;

final class Auth extends \Prefab
{
    private ?array $user = null;

    function __construct()
    {
        $session_user = \Base::instance()->get('SESSION.user');

        if (! empty($session_user['cached_at']) && $session_user['cached_at'] < (time() - CACHE_TTL_SECONDS)) {
            $db_user = new User();
            $db_user->load(['id=?', $session_user['id']]);
            $session_user['name'] = $db_user->name;
            $session_user['email'] = $db_user->email;
            $session_user['cached_at'] = time();

            \Base::instance()->set('SESSION.user', $session_user);
        }

        $this->user = $session_user;
    }

    public static function user(): array|null
    {
        return self::instance()->user;
    }

    public static function set_user(array|Mapper $values): void
    {
        $data =  [
            'id' => $values['_id'],
            'name' => $values['name'],
            'email' => $values['email'],
            'role' => $values['role'],
            'cached_at' => time(),
        ];

        if (empty($data['name']) || empty($data['email'])) {
            throw new InvalidArgumentException('User must have a name and email');
        }

        \Base::instance()->set('SESSION.user', $data);
        self::instance()->user = $data;
    }

    public static function check(): bool
    {
        return self::instance()->user != null;
    }

    public static function clear(): void
    {
        \Base::instance()->clear('SESSION.user');
        self::instance()->user = null;
    }
}
