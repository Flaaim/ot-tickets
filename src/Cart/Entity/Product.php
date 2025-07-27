<?php

namespace App\Cart\Entity;

class Product
{
    private Id $id;
    private string $name;
    private string $description;
    private string $price;
    private string $cipher;

    public function __construct(Id $id)
    {
        $this->id = $id;
    }
    public function isEqualTo(self $product): bool
    {
        return $product->getId() === $this->getId();
    }

    public function getId(): Id
    {
        return $this->id;
    }
}
