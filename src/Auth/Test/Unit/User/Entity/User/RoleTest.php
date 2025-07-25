<?php

namespace App\Auth\Test\Unit\User\Entity\User;

use App\Auth\Entity\Role;
use App\Auth\Test\Builder\UserBuilder;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RoleTest extends TestCase
{
    public function testSuccess(): void
    {
        $role = new Role($name = Role::ADMIN);

        self::assertEquals($name, $role->getName());

    }
    public function testIncorrect(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Role('none');
    }

    public function testEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Role('');
    }

    public function testUserFactory(): void
    {
        $role = Role::user();

        self::assertEquals(Role::USER, $role->getName());
    }
}
