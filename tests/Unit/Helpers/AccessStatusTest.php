<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use DB\SQL;
use Enums\PlanSlug;
use Http\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Support\AccessStatus;
use Tests\TestCase;

final class AccessStatusTest extends TestCase
{
    private array $user;
    protected null|SQL $db;

    protected function setUp(): void
    {
        parent::setUp();
        $user = new User();
        $user->copyFrom(['name' => 'John', 'email' => 'john@gmail.com', 'password' => 'password']);
        $user->save();
        $this->user = ['id' => $user->id, ...$user->cast()];
        $this->db = \Base::instance()->get('DB');
    }

    #[Test]
    public function add_one_month_access_to_new_user(): void
    {
        $this->assertFalse(AccessStatus::has_active_subscription($this->user));
        AccessStatus::give(PlanSlug::MONTHLY, $this->user);

        $this->assertTrue(AccessStatus::has_active_subscription($this->user));

    }
}
