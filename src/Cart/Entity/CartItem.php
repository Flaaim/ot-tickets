<?php

namespace App\Cart\Entity;

use App\Product\Entity\Product;
use App\Shared\Domain\ValueObject\Id;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'items')]
class CartItem
{
    #[ORM\Id]
    #[ORM\Column(type: 'id', unique: true)]
    private Id $id;
    #[ORM\ManyToOne(targetEntity: Cart::class,  inversedBy: 'items')]
    private Cart $cart;
    #[ORM\ManyToOne(targetEntity: Product::class)]
    private Product $product;
    #[ORM\Column(type: 'integer')]
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
        return $this->product->getId()->equals($item->getProduct()->getId());
    }

    public function setCart(Cart $cart): void
    {
        $this->cart = $cart;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }
}
