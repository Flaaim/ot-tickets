<?php

namespace App\Product\Test\Unit\CreateProduct;

use App\Product\Entity\Price;
use App\Product\Entity\Product;
use App\Shared\Domain\ValueObject\Id;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class CreateProductTest extends TestCase
{
    public function testSuccess(): void
    {
        $product = new Product(
            $id = Id::generate(),
            $name = 'Test Product',
            $description = 'Test Description',
            $price = new Price(100),
            $cipher = 'AES-128-CBC',
            $updatedAt = new DateTimeImmutable(),
        );

        $this->assertEquals($id, $product->getId());
        $this->assertEquals($name, $product->getName());
        $this->assertEquals($description, $product->getDescription());
        $this->assertEquals($price, $product->getPrice());
        $this->assertEquals($cipher, $product->getCipher());
        $this->assertEquals($updatedAt, $product->getUpdatedAt());
    }
}
