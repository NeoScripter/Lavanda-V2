<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use Enums\PlanSlug;
use Http\Models\Access;
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
    public function rejects_creating_a_second_access_with_the_same_user(): void
    {
        $sub1 = new Access();
        $sub1->user = $this->user;
        $sub1->save();

        $this->expectException(InvalidArgumentException::class);

        $sub2 = new Access();
        $sub2->user = $this->user;
        $sub2->save();

    }

    #[Test]
    public function rejects_assigning_a_second_subscription_to_the_same_user(): void
    {
        $sub1 = new Access();
        $sub1->save();
        $this->user->access = $sub1;
        $this->user->save();

        $this->expectException(InvalidArgumentException::class);

        $sub2 = new Access();
        $sub2->save();
        $this->user->access = $sub2;
        $this->user->save();
    }
}
