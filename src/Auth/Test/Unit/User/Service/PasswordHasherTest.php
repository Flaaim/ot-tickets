<?php

namespace App\Auth\Test\Unit\User\Service;

use App\Auth\Service\PasswordHasher;
use PHPUnit\Framework\TestCase;

class PasswordHasherTest extends TestCase
{
    public function testHashSuccess(): void
    {
        $hasher = new PasswordHasher();
        $hash = $hasher->hash($password = '123456');
        self::assertNotEquals($password, $hash);
        self::assertEquals(password_verify($password, $hash), $hasher->hash('123456'));
    }

    public function testHashEmpty(): void
    {
        $hasher = new PasswordHasher();
        $this->expectException(\InvalidArgumentException::class);
        $hash = $hasher->hash('');
    }
    public function testHashValidate(): void
    {
        $hasher = new PasswordHasher();

        $hash = $hasher->hash($password = '123456');
        self::assertTrue($hasher->validate($password, $hash));
        self::assertFalse($hasher->validate($password = 'wrong-password', $hash));
    }
}
