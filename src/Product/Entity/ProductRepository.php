<?php

namespace App\Product\Entity;

use App\Shared\Domain\ValueObject\Id;

interface ProductRepository
{
    /**
     * @param Id $id
     * @return Product
     * @throws \DomainException
     */
    public function get(Id $id): Product;

    public function save(Product $product): void;
}
