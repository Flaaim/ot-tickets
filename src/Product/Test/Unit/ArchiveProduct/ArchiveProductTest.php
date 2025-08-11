<?php

namespace App\Product\Test\Unit\ArchiveProduct;

use App\Product\Test\Builder\ProductBuilder;
use PHPUnit\Framework\TestCase;

class ArchiveProductTest extends TestCase
{
    public function testSuccess(): void
    {
        $product = (new ProductBuilder())->build();

        $product->archive();

        self::assertTrue($product->getStatus()->isArchived());
    }

    public function testAlreadyArchived(): void
    {
        $product = (new ProductBuilder())->build();
        $product->archive();
        $this->expectExceptionMessage('Product is already archived.');
        $product->archive();
    }

    public function testAlreadyActive(): void
    {
        $product = (new ProductBuilder())->archive()->build();

        $product->activate();
        $this->expectExceptionMessage('Product is already active.');
        $product->activate();
    }
}
