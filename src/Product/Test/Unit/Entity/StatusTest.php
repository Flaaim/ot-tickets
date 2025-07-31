<?php

namespace App\Product\Test\Unit\Entity;


use App\Product\Entity\Status;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Product\Entity\Status
 */
class StatusTest extends TestCase
{
    public function testActive(): void
    {
        $status = Status::active();

        self::assertTrue($status->isActive());
        self::assertFalse($status->isArchived());
    }

    public function testArchived(): void
    {
        $status = Status::archive();

        self::assertTrue($status->isArchived());
        self::assertFalse($status->isActive());
    }
}
