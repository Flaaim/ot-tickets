<?php

namespace App\Product\Entity;

use ArrayObject;

class PaginatedResults
{
    /**
     * @param array<Product> $items
     */
    public function __construct(
        public readonly array $items,
        public readonly int $totalItems,
        public readonly int $currentPage,
        public readonly int $perPage,
        public readonly int $totalPages
    ) {}

    public static function create(
        array $items,
        int $totalItems,
        int $page,
        int $perPage
    ): self {
        return new self(
            items: $items,
            totalItems: $totalItems,
            currentPage: $page,
            perPage: $perPage,
            totalPages: (int) ceil($totalItems / $perPage)
        );
    }

}
