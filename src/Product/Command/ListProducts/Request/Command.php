<?php

namespace App\Product\Command\ListProducts\Request;

use Webmozart\Assert\Assert;

class Command
{
    public function __construct(
        public readonly ?string $searchQuery = null,
        public readonly ?float $minPrice = null,
        public readonly ?float $maxPrice = null,
        public readonly ?string $sortBy = 'name',
        public readonly ?string $sortOrder = 'asc',
        public readonly int $page = 1,
        public readonly int $perPage = 20,
    )
    {
        Assert::nullOrLengthBetween($searchQuery, 1, 255);
        Assert::nullOrGreaterThan($minPrice, 0);
        Assert::nullOrGreaterThan($maxPrice, 0);
        Assert::oneOf($sortBy, ['name', 'price', 'updatedAt']);
        Assert::oneOf($sortOrder, ['asc', 'desc']);
        Assert::positiveInteger($page);
        Assert::positiveInteger($perPage);
        Assert::lessThanEq($perPage, 100);
    }
}
