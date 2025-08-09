<?php

namespace App\Cart\Test\Unit\AddToCart;

use App\Cart\Entity\Cart;
use App\Cart\Entity\CartItem;
use App\Product\Test\Builder\ProductBuilder;
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

        $item = new CartItem(
            new Id(Uuid::uuid4()->toString()),
            $product,
            1
        );
        $cart->addItem($item);

        $this->assertCount(1, $existingItem = $cart->getItems());
        $this->assertEquals($item, $existingItem[0]);
    }

    public function testAlreadyExists(): void
    {
        $cart = new Cart(
            new Id(Uuid::uuid4()->toString())
        );
        $product = (new ProductBuilder())->build();
        $item = new CartItem(
            new Id(Uuid::uuid4()->toString()),
            $product,
            1
        );
        $cart->addItem($item);
        $this->expectExceptionMessage('Item already exists.');

        $cart->addItem($item);
    }
}
