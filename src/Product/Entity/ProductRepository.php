<?php

namespace App\Product\Entity;

interface ProductRepository
{
    /**
     * @param Id $id
     * @return Product
     * @throws \DomainException
     */
    public function get(Id $id): Product;
}
