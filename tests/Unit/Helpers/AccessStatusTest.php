<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use DateInterval;
use DateTime;
use DB\SQL;
use Enums\PlanSlug;
use Http\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Support\AccessStatus;
use Support\Clock;
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

        Clock::reset();

        $this->user = ['id' => $user->id, ...$user->cast()];
        $this->db = \Base::instance()->get('DB');
    }

    #[Test]
    public function adds_one_month_access_to_new_user(): void
    {
        $this->assertFalse(AccessStatus::has_active_subscription($this->user));
        AccessStatus::give(PlanSlug::MONTHLY, $this->user);

        $this->assertTrue(AccessStatus::has_active_subscription($this->user));

        Clock::turn_forward('P30D');

        $this->assertTrue(AccessStatus::has_active_subscription($this->user));

        Clock::turn_forward('P2M');

        $this->assertFalse(AccessStatus::has_active_subscription($this->user));
    }

    #[Test]
    public function sums_up_two_subscriptions(): void
    {
        $this->assertFalse(AccessStatus::has_active_subscription($this->user));
        AccessStatus::give(PlanSlug::MONTHLY, $this->user);
        AccessStatus::give(PlanSlug::MONTHLY, $this->user);

        $this->assertTrue(AccessStatus::has_active_subscription($this->user));

        Clock::turn_forward('P60D');

        $this->assertTrue(AccessStatus::has_active_subscription($this->user));

        $rows = \Base::instance()->get("DB")->exec(
            "SELECT count(id) FROM subscriptions s WHERE s.user = ?",
            [$this->user['id']]
        );

        $this->assertEquals(expected: 1, actual: $rows[0]['count']);
    }
}
