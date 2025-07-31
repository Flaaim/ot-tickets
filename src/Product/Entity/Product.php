<?php

namespace App\Product\Entity;

use App\Shared\Domain\ValueObject\Id;
use DateTimeImmutable;
use Webmozart\Assert\Assert;

class Product
{
    public function __construct(
        private Id $id,
        private string $name,
        private string $description,
        private Price $price,
        private string $cipher,
        private DateTimeImmutable $updatedAt
    ) {
        Assert::minLength($this->name, 3);
        Assert::minLength($this->description, 10);
        Assert::regex($this->cipher, '/^[A-Za-z0-9-]+$/');
    }
    public function isEqualTo(self $product): bool
    {
        return $product->getId() === $this->getId();
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

    public function changePrice(Price $price): void
    {
        $this->price = $price;
    }
    public function changeName(?string $name): void
    {
        $this->name = $name;
    }
    public function changeDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function changeCipher(?string $cipher): void
    {
        $this->cipher = $cipher;
    }
}
