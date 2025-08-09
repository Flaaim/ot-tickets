<?php

namespace App\Cart\Entity;

use App\Product\Entity\Product;
use App\Shared\Domain\ValueObject\Id;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'cart_items')]
class CartItem
{
    private Id $id;
    private Product $product;
    private int $quantity;
    public function __construct(Id $id, Product $product, int $quantity = 1)
    {
        $this->id = $id;
        $this->product = $product;
        $this->quantity = $quantity;
    }
    public function getId(): Id
    {
        return $this->id;
    }
    public function getProduct(): Product
    {
        return $this->product;
    }
    public function getQuantity(): int
    {
        return $this->quantity;
    }
    public function isEqualTo(self $item): bool
    {
        return $this->id === $item->id;
    }
}
