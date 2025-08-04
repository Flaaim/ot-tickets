<?php

namespace App\Product\Test\Builder;

use App\Product\Entity\Price;
use App\Product\Entity\Product;
use App\Product\Entity\Status;
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
    private Status $status;

    public function __construct(
    ){
        $this->id = new Id(Uuid::uuid4());
        $this->name = 'Product name';
        $this->description = 'Product description';
        $this->price = new Price('200', 'RUB');
        $this->cipher = 'cipher';
        $this->updatedAt = new DateTimeImmutable('now');
        $this->status = Status::active();
    }

    public function build(): Product
    {
        $product = new Product(
            $this->id,
            $this->name,
            $this->description,
            $this->price,
            $this->cipher,
            $this->updatedAt,
            $this->status
        );

        return $product;
    }
    public function archive(): self
    {
        $clone = clone $this;
        $clone->status = Status::archive();
        return $clone;
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
