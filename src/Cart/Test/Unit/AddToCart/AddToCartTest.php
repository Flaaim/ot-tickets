<?php

namespace App\Cart\Test\Unit\AddToCart;

use App\Cart\Entity\Cart;
use App\Cart\Test\Unit\Builder\ProductBuilder;
use App\Product\Entity\Product;
use App\Shared\Domain\ValueObject\Id;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AddToCartTest extends TestCase
{
    public function testSuccess(): void
    {
        $cart = new Cart(
            new Id(Uuid::uuid4()->toString())
        );

        $product = (new ProductBuilder())->build();

        $cart->addProduct($product);

        $this->assertCount(1, $existingProduct = $cart->getProducts());
        $this->assertEquals($product, $existingProduct[0]);
    }

    public function testAlreadyExists(): void
    {
        $cart = new Cart(
            new Id(Uuid::uuid4()->toString())
        );
        $product = (new ProductBuilder())->build();

        $cart->addProduct($product);
        $this->expectExceptionMessage('Product already exists.');

        $cart->addProduct($product);
    }
}
