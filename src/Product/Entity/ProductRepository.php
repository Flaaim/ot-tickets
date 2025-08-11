<?php

namespace App\Product\Entity;

use App\Shared\Domain\ValueObject\Id;
use ArrayObject;

interface ProductRepository
{
    /**
     * @param Id $id
     * @return Product
     * @throws \DomainException
     */
    public function get(Id $id): Product;

    public function save(Product $product): void;

    public function findByQuery(string $query): ?Product;

    public function findAllPaginated(
        string $searchQuery,
        float $minPrice,
        float $maxPrice,
        string $sortBy,
        string $sortOrder,
        int $page,
        int $perPage,
    ): PaginatedResults; //return PaginatedResults::create(....)
}
