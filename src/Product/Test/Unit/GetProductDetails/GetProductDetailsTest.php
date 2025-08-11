<?php

namespace App\Product\Test\Unit\GetProductDetails;

use App\Product\Test\Builder\ProductBuilder;
use PHPUnit\Framework\TestCase;

class GetProductDetailsTest extends TestCase
{
    public function testSuccess(): void
    {
        $product = ($productBuilder = new ProductBuilder())->build();

        $this->assertEquals($product->getId(), $productBuilder->getId());
        $this->assertEquals($product->getName(), $productBuilder->getName());
        $this->assertEquals($product->getPrice(), $productBuilder->getPrice());
        $this->assertEquals($product->getPrice(), $productBuilder->getPrice());
        $this->assertEquals($product->getCipher(), $productBuilder->getCipher());
        $this->assertEquals($product->getUpdatedAt(), $productBuilder->getUpdatedAt());
    }
}
