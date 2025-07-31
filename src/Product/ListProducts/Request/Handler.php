<?php

namespace App\Product\ListProducts\Request;

use App\Product\Entity\PaginatedResults;
use App\Product\Entity\ProductRepository;
use App\Product\ListProducts\Response\ListProductResponse;

class Handler
{
    private ProductRepository $products;
    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    public function handle(Command $command): ListProductResponse
    {
        $results = $this->products->findAllPaginated(
            searchQuery: $command->searchQuery,
            minPrice: $command->minPrice,
            maxPrice: $command->maxPrice,
            sortBy: $command->sortBy,
            sortOrder: $command->sortOrder,
            page: $command->page,
            perPage: $command->perPage
        );

        return new ListProductResponse($results);
    }

}
