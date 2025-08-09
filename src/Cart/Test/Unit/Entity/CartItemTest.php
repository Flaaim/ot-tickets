<?php

namespace App\Cart\Test\Unit\Entity;

use App\Cart\Entity\CartItem;
use App\Cart\Entity\Item;
use App\Product\Test\Builder\ProductBuilder;
use App\Shared\Domain\ValueObject\Id;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

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
}
