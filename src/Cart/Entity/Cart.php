<?php

namespace App\Cart\Entity;

use ArrayObject;

class Cart
{
    private Id $id;
    private ArrayObject $products;
    public function __construct(Id $id)
    {
        $this->id = $id;
        $this->products = new ArrayObject();
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
        $this->products->append($product);
    }

    public function getProducts(): array
    {
        return $this->products->getArrayCopy();
    }
}
