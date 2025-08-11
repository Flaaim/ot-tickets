<?php

namespace App\Cart\Test\Unit\Entity;

use App\Cart\Entity\Quantity;
use PHPUnit\Framework\TestCase;

class QuantityTest extends TestCase
{
    public function testSuccess(): void
    {
        $quantity = new Quantity(Quantity::DEFAULT);

        $this->assertNotNull($quantity->getValue());
        $this->assertEquals(Quantity::DEFAULT, $quantity->getValue());
    }

    public function testInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Quantity(2);
    }

}
