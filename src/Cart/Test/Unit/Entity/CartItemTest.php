<?php

namespace App\Cart\Test\Unit\Entity;

use App\Auth\Test\Builder\UserBuilder;
use App\Cart\Entity\Cart;
use App\Cart\Entity\CartItem;
use App\Cart\Entity\Quantity;
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
            $quantity = Quantity::default(),
        );

        $this->assertEquals($id, $item->getId());
        $this->assertSame($product, $item->getProduct());
        $this->assertSame($quantity->getValue(), $item->getQuantity());
    }

    public function testIsEquals(): void
    {
        $product = (new ProductBuilder())->build();

        $item = new CartItem(ID::generate(), $product, Quantity::default());
        $equalsItem = new CartItem(ID::generate(), clone $product, Quantity::default());
        $notEqualsItem = new CartItem(ID::generate(), (new ProductBuilder())->build(), Quantity::default());


        $this->assertTrue($item->isEqualTo($item));
        $this->assertTrue($item->isEqualTo($equalsItem));

        $this->assertFalse($item->isEqualTo($notEqualsItem));
    }

    public function testSetCart(): void
    {
        $product = (new ProductBuilder())->build();
        $item = new CartItem(ID::generate(), $product, Quantity::default());

        $cart = new Cart(ID::generate(), (new UserBuilder())->build());
        $item->setCart($cart);

        $this->assertNotNull($item->getCart());
        $this->assertSame($cart, $item->getCart());
    }
}
