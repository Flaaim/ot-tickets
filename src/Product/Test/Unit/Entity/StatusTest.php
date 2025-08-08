<?php

namespace App\Product\Test\Unit\Entity;


use App\Product\Entity\Status;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Product\Entity\Status
 */
class StatusTest extends TestCase
{
    public function testSuccess(): void
    {
        $status = new Status($value = Status::ACTIVE);

        $this->assertNotNull($status->getName());
        $this->assertSame($value, $status->getName());
    }
    public function testInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Status('invalid');
    }
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
