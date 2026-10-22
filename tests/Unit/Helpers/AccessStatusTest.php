<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use DateInterval;
use DateTime;
use DB\SQL;
use Enums\PlanSlug;
use Http\Models\Subscription;
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
    public function adds_one_year_access_to_new_user(): void
    {
        $this->assertFalse(AccessStatus::has_active_subscription($this->user));
        AccessStatus::give(PlanSlug::YEARLY, $this->user);

        $this->assertTrue(AccessStatus::has_active_subscription($this->user));

        Clock::turn_forward('P11M');

        $this->assertTrue(AccessStatus::has_active_subscription($this->user));

        Clock::turn_forward('P13M');

        $this->assertFalse(AccessStatus::has_active_subscription($this->user));
    }

    #[Test]
    public function sums_up_several_subscriptions(): void
    {
        $this->assertFalse(AccessStatus::has_active_subscription($this->user));
        AccessStatus::give(PlanSlug::MONTHLY, $this->user);
        AccessStatus::give(PlanSlug::MONTHLY, $this->user);

        $this->assertTrue(AccessStatus::has_active_subscription($this->user));

        Clock::turn_forward('P60D');

        $this->assertTrue(AccessStatus::has_active_subscription($this->user));

        Clock::turn_forward('P62D');

        $this->assertFalse(AccessStatus::has_active_subscription($this->user));

        AccessStatus::give(PlanSlug::YEARLY, $this->user);

        Clock::turn_forward('P13M');

        $this->assertTrue(AccessStatus::has_active_subscription($this->user));

        AccessStatus::give(PlanSlug::YEARLY, $this->user);

        Clock::turn_forward('P25M');

        $this->assertTrue(AccessStatus::has_active_subscription($this->user));

        $rows = \Base::instance()->get("DB")->exec(
            "SELECT count(id) FROM subscriptions s WHERE s.user = ?",
            [$this->user['id']]
        );

        $this->assertEquals(expected: 1, actual: $rows[0]['count']);
    }

    #[Test]
    public function disregards_expired_subscription_when_purchasing_a_new_one(): void
    {
        $this->assertFalse(AccessStatus::has_active_subscription($this->user));

        $expired = new Subscription();
        $expired->ends_at = new DateTime()->sub(new DateInterval('P3M'))->format('Y-m-d H:i:s');
        $expired->plan_slug = PlanSlug::YEARLY->value;
        $expired->user = $this->user['id'];
        $expired->save();

        $this->assertFalse(AccessStatus::has_active_subscription($this->user));

        AccessStatus::give(PlanSlug::MONTHLY, $this->user);

        Clock::turn_forward('P30D');

        $this->assertTrue(AccessStatus::has_active_subscription($this->user));
    }

    #[Test]
    public function gives_user_game_access(): void
    {
        $this->assertFalse(AccessStatus::has_purchased_games($this->user));
        AccessStatus::give(PlanSlug::ONE_TIME, $this->user);
        $this->assertTrue(AccessStatus::has_purchased_games($this->user));
    }

    #[Test]
    public function sums_up_game_numbers(): void
    {
        $this->assertFalse(AccessStatus::has_purchased_games($this->user));
        AccessStatus::give(PlanSlug::ONE_TIME, $this->user);
        AccessStatus::give(PlanSlug::ONE_TIME, $this->user);
        AccessStatus::give(PlanSlug::ONE_TIME, $this->user);

        $rows = \Base::instance()->get("DB")->exec(
            "SELECT count(id) FROM games g WHERE g.user = ?",
            [$this->user['id']]
        );

        $this->assertEquals(expected: 1, actual: $rows[0]['count']);

        $rows = \Base::instance()->get("DB")->exec(
            "SELECT number FROM games g WHERE g.user = ? LIMIT 1",
            [$this->user['id']]
        );

        $this->assertEquals(expected: 9, actual: $rows[0]['number']);
    }

    #[Test]
    public function sums_up_consultation_numbers(): void
    {
        $this->assertFalse(AccessStatus::has_purchased_consultations($this->user));
        AccessStatus::give(PlanSlug::PERSONAL, $this->user);
        $this->assertTrue(AccessStatus::has_purchased_consultations($this->user));
    }

    #[Test]
    public function gives_user_consultation_access(): void
    {
        $this->assertFalse(AccessStatus::has_purchased_consultations($this->user));
        AccessStatus::give(PlanSlug::PERSONAL, $this->user);
        AccessStatus::give(PlanSlug::PERSONAL, $this->user);
        AccessStatus::give(PlanSlug::PERSONAL, $this->user);

        $rows = \Base::instance()->get("DB")->exec(
            "SELECT count(id) FROM consultations c WHERE c.user = ?",
            [$this->user['id']]
        );

        $this->assertEquals(expected: 1, actual: $rows[0]['count']);

        $rows = \Base::instance()->get("DB")->exec(
            "SELECT number FROM consultations c WHERE c.user = ? LIMIT 1",
            [$this->user['id']]
        );

        $this->assertEquals(expected: 3, actual: $rows[0]['number']);
    }
}
