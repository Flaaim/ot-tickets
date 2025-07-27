<?php

namespace App\Auth\Test\Unit\User\ChangeRole;

use App\Auth\Entity\Role;
use App\Auth\Test\Builder\UserBuilder;
use PHPUnit\Framework\TestCase;

class ChangeRoleTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())->active()->build();

        $user->changeRole($role = new Role(Role::ADMIN));

        self::assertEquals($role, $user->getRole());
    }
}
