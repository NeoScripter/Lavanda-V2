<?php

declare(strict_types=1);

namespace Support;

use DB\SQL\Mapper;
use Http\Models\User;
use InvalidArgumentException;

const TTL_MS = 60 * 60 * 24;

final class Auth extends \Prefab
{
    private ?array $user;

    function __construct()
    {
        $hive = \Base::instance();
        $session_user = $hive->get('SESSION.user');

        if (empty($session_user)) {
            $this->user = null;
            return;
        }

        if ($session_user['cached_at'] < (time() - 10)) {
            $user = new User();
            $user->load(['id = ?', $session_user['id']]);

            $session_user['name'] = $user['name'];
            $session_user['email'] = $user['email'];
            $session_user['cached_at'] = time();
            $hive->set('SESSION.user', $session_user, TTL_MS);
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
            'id' => $values['id'] ?? $values['_id'],
            'name' => $values['name'],
            'email' => $values['email'],
            'role' => $values['role'],
            'cached_at' => time(),
        ];

        if (empty($data['name']) || empty($data['email']) || empty($data['role'])) {
            throw new InvalidArgumentException('User must have a name, role, and email');
        }

        $hive = \Base::instance();

        $hive->set('SESSION.user', $data, TTL_MS);

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
