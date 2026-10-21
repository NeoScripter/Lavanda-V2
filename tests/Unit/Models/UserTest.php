<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use Enums\ConsultationType;
use Enums\PlanSlug;
use Http\Models\Consultation;
use Http\Models\Subscription;
use Http\Models\User;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class UserTest extends TestCase
{
    private ?User $user = null;

    protected function setUp(): void
    {
        parent::setUp();
        $user = new User();
        $user->copyFrom(['name' => 'John', 'email' => 'john@gmail.com', 'password' => 'password']);
        $user->save();
        $this->user = $user;
    }

    #[Test]
    public function rejects_creating_a_subscription_with_the_same_user(): void
    {
        $sub1 = new Subscription();
        $sub1->plan_slug = PlanSlug::ONE_TIME->value;
        $sub1->user = $this->user;
        $sub1->save();

        $this->expectException(InvalidArgumentException::class);

        $sub2 = new Subscription();
        $sub2->plan_slug = PlanSlug::MONTHLY->value;
        $sub2->user = $this->user;
        $sub2->save();

    }

    #[Test]
    public function rejects_assigning_a_second_subscription_to_the_same_user(): void
    {
        $sub1 = new Subscription();
        $sub1->plan_slug = PlanSlug::ONE_TIME->value;
        $sub1->save();
        $this->user->subscription = $sub1;
        $this->user->save();

        $this->expectException(InvalidArgumentException::class);

        $sub2 = new Subscription();
        $sub2->plan_slug = PlanSlug::ONE_TIME->value;
        $sub2->save();
        $this->user->subscription = $sub2;
        $this->user->save();
    }

    #[Test]
    public function rejects_creating_a_consultation_with_the_same_user(): void
    {
        $consultation1 = new Consultation();
        $consultation1->plan_slug = PlanSlug::ONE_TIME->value;
        $consultation1->type = ConsultationType::GAME->value;
        $consultation1->user = $this->user;
        $consultation1->save();

        $this->expectException(InvalidArgumentException::class);

        $consultation2 = new Consultation();
        $consultation2->plan_slug = PlanSlug::MONTHLY->value;
        $consultation1->type = ConsultationType::GAME->value;
        $consultation2->user = $this->user;
        $consultation2->save();

    }

    #[Test]
    public function rejects_assigning_a_second_consultation_to_the_same_user(): void
    {
        $consultation1 = new Consultation();
        $consultation1->plan_slug = PlanSlug::ONE_TIME->value;
        $consultation1->type = ConsultationType::GAME->value;
        $consultation1->save();
        $this->user->consultation = $consultation1;
        $this->user->save();

        $this->expectException(InvalidArgumentException::class);

        $consultation2 = new Consultation();
        $consultation2->plan_slug = PlanSlug::ONE_TIME->value;
        $consultation2->type = ConsultationType::SURVEY->value;
        $consultation2->save();
        $this->user->consultation = $consultation2;
        $this->user->save();
    }
}
