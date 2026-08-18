<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers;

use Http\Controllers\CliController;
use Http\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class CliControllerTest extends TestCase
{

    #[Test]
    public function creating_existing_user_does_not_throw(): void
    {
        $user = new User();
        $user_data = ['name' => 'John', 'email' => 'example@email.com', 'password' => 'password'];
        $user->copyfrom($user_data);
        $user->save();

        $this->hive->set('GET', $user_data);

        $this->assertFalse((new CliController)->create_user($this->hive));
    }
}
