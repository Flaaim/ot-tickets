<?php

namespace App\Auth\Test\Unit\Entity\User;


use App\Auth\Entity\Status;
use PHPUnit\Framework\TestCase;

class StatusTest extends TestCase
{
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
