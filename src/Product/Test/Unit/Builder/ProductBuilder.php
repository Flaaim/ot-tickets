<?php

namespace App\Product\Test\Unit\Builder;

use App\Product\Entity\Price;
use App\Product\Entity\Product;
use App\Shared\Domain\ValueObject\Id;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

class ProductBuilder
{
    private Id $id;
    private string $name;
    private string $description;
    private Price $price;
    private string $cipher;
    private DateTimeImmutable $updatedAt;

    public function __construct(
    ){
        $this->id = new Id(Uuid::uuid4());
        $this->name = 'Product name';
        $this->description = 'Product description';
        $this->price = new Price('200', 'RUB');
        $this->cipher = 'cipher';
        $this->updatedAt = new DateTimeImmutable('now');
    }

    public function build(): Product
    {
        $product = new Product(
            $this->id,
            $this->name,
            $this->description,
            $this->price,
            $this->cipher,
            $this->updatedAt
        );

        return $product;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getCipher(): string
    {
        return $this->cipher;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
