<?php

namespace App\Cart\Entity;

use App\Product\Entity\Product;
use App\Shared\Domain\ValueObject\Id;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


class Cart
{
    private Id $id;
    private Collection $products;
    public function __construct(Id $id)
    {
        $this->id = $id;
        $this->products = new ArrayCollection();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function addProduct(Product $product): void
    {
        foreach ($this->products as $existingProduct) {
            if($product->isEqualTo($existingProduct)) {
                throw new \DomainException("Product already exists.");
            }
        }
        $this->products->add($product);
    }

    public function getProducts(): array
    {
        return $this->products->toArray();
    }
}
