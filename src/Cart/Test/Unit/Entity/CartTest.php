<?php

namespace App\Cart\Test\Unit\Entity;

use App\Auth\Entity\User;
use App\Auth\Test\Builder\UserBuilder;
use App\Cart\Entity\Cart;
use App\Cart\Entity\CartItem;
use App\Product\Entity\Product;
use App\Product\Test\Builder\ProductBuilder;
use App\Shared\Domain\ValueObject\Id;
use DomainException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CartTest extends TestCase
{
    public function testCart(): void
    {
        $cart = new Cart(
            $id = new Id(Uuid::uuid4()->toString()),
        );

        $this->assertNotNull($cart->getId());
        $this->assertEquals($cart->getId(), $id);

    }
    public function testAddToCart(): void
    {
        $cart = new Cart(ID::generate());

        $item = new CartItem(ID::generate(), (new ProductBuilder())->build());
        $cart->addItem($item);

        $this->assertCount(1, $cart->getItems());
        $this->assertEquals($item, $cart->getItems()[0]);
    }
    public function testAddExistingItem(): void
    {
        $cart = new Cart(ID::generate());
        $product = (new ProductBuilder())->build();

        $item = new CartItem(ID::generate(), $product);

        $cart->addItem($item);

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage("Item already exists.");
        $cart->addItem($item);
    }

    public function testEmptyCart(): void
    {
        $cart = new Cart(ID::generate());

        $this->assertEmpty($cart->getItems());
    }
}
