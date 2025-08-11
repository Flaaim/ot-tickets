<?php

namespace App\Auth\Test\Unit\User\Entity\User;


use App\Auth\Entity\Status;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class StatusTest extends TestCase
{
    public function testSuccess(): void
    {
        $status = new Status($value = Status::ACTIVE);

        $this->assertNotNull($status->getName());
        $this->assertSame($status->getName(), $value);
    }
    public function testInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Status('invalid');

    }
    public function testActive(): void
    {
        $status = Status::active();

        self::assertTrue($status->isActive());
        self::assertFalse($status->isWait());
    }

    public function testWait(): void
    {
        $status = Status::wait();

        self::assertTrue($status->isWait());
        self::assertFalse($status->isActive());
    }
}
