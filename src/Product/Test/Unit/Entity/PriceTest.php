<?php

namespace App\Product\Test\Unit\Entity;

use App\Product\Entity\Price;
use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{
    public function testPrice(): void
    {
        $price = new Price($value = 12.34);

        $this->assertNotNull($price->getValue());
        $this->assertEquals($value, $price->getValue());
    }

    public function testZero(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Price(0);
    }

    public function testAddPrice(): void
    {
        $price = (new Price($value = 12.34))->add(new Price($other = 12.34));
        $sum = $value + $other;

        $this->assertEquals($sum, $price->getValue());
    }
    public function testSubtractPrice(): void
    {
        $price = (new Price($value = 12.34))->subtract(new Price($other = 12.34));
        $subtract = $value - $other;
        $this->assertEquals($subtract, $price->getValue());
    }

    public function testEqualPrice(): void
    {
        $price = new Price(12.34);

        $other = new Price(12.34);

        $this->assertTrue($price->equals($other));
    }
}
