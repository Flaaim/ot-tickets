<?php

namespace App\Cart\Test\Unit\Entity;

use App\Cart\Entity\Cart;
use App\Cart\Entity\CartItem;
use App\Product\Test\Builder\ProductBuilder;
use App\Shared\Domain\ValueObject\Id;
use PHPUnit\Framework\TestCase;

class CartItemTest extends TestCase
{
    public function testSuccess(): void
    {
        $item = new CartItem(
            $id = ID::generate(),
            $product = (new ProductBuilder())->build(),
            $quantity = 1,
        );

        $this->assertEquals($id, $item->getId());
        $this->assertSame($product, $item->getProduct());
        $this->assertSame($quantity, $item->getQuantity());
    }

    public function testIsEquals(): void
    {
        $product = (new ProductBuilder())->build();

        $item = new CartItem(ID::generate(), $product);
        $equalsItem = new CartItem(ID::generate(), clone $product);
        $notEqualsItem = new CartItem(ID::generate(), (new ProductBuilder())->build());


        $this->assertTrue($item->isEqualTo($item));
        $this->assertTrue($item->isEqualTo($equalsItem));

        $this->assertFalse($item->isEqualTo($notEqualsItem));
    }

    public function testSetCart(): void
    {
        $product = (new ProductBuilder())->build();
        $item = new CartItem(ID::generate(), $product);

        $cart = new Cart(ID::generate());
        $item->setCart($cart);

        $this->assertNotNull($item->getCart());
        $this->assertSame($cart, $item->getCart());
    }
}
