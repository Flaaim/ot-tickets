<?php

namespace App\Cart\Test\Unit\Entity;

use App\Cart\Entity\Cart;
use App\Shared\Domain\ValueObject\Id;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CartTest extends TestCase
{
    public function testCart(): void
    {
        $cart = new Cart(
            $id = new Id(Uuid::uuid4()->toString()),
        );

        $this->assertEquals($cart->getId(), $id);
    }
}
