<?php

namespace App\Product\SearchProduct\Response;

use App\Product\Entity\Product;
use DateTimeImmutable;

class SearchProductResponse
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $description,
        private readonly string $price,
        private readonly string $cipher,
        private readonly DateTimeImmutable $updatedAt,
    ){}

    public static function fromProduct(Product $product): self
    {
        return new self(
            $product->getId()->getValue(),
            $product->getName(),
            $product->getDescription(),
            $product->getPrice()->formatted(),
            $product->getCipher(),
            $product->getUpdatedAt()
        );
    }
}
