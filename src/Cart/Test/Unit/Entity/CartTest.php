<?php

namespace App\Cart\Test\Unit\Entity;


use App\Auth\Test\Builder\UserBuilder;
use App\Cart\Entity\Cart;
use App\Cart\Entity\CartItem;
use App\Cart\Entity\Quantity;
use App\Product\Test\Builder\ProductBuilder;
use App\Shared\Domain\ValueObject\Id;
use DomainException;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    public function testCart(): void
    {
        $cart = new Cart(
            $id = Id::generate(),
             (new UserBuilder())->build()
        );

        $this->assertNotNull($cart->getId());
        $this->assertEquals($cart->getId(), $id);

    }
    public function testAddToCart(): void
    {
        $cart = new Cart(ID::generate(), (new UserBuilder())->build());

        $item = new CartItem(ID::generate(), (new ProductBuilder())->build(), Quantity::default());
        $cart->addItem($item);

        $this->assertCount(1, $cart->getItems());
        $this->assertEquals($item, $cart->getItems()[0]);
    }
    public function testAddExistingItem(): void
    {
        $cart = new Cart(ID::generate(), (new UserBuilder())->build());
        $product = (new ProductBuilder())->build();

        $item = new CartItem(ID::generate(), $product, Quantity::default());

        $cart->addItem($item);

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage("Item already exists.");
        $cart->addItem($item);
    }

    public function testEmptyCart(): void
    {
        $cart = new Cart(ID::generate(), (new UserBuilder())->build());

        $this->assertEmpty($cart->getItems());
    }
}
