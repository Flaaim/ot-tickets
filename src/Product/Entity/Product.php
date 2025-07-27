<?php

namespace App\Product\Entity;

use App\Shared\Domain\ValueObject\Id;
use DateTimeImmutable;

class Product
{
    private Id $id;
    private string $name;
    private string $description;
    private Price $price;
    private string $cipher;

    public function __construct(Id $id, string $name, string $description, Price $price, string $cipher, DateTimeImmutable $updatedAt)
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
