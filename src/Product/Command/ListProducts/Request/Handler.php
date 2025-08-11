<?php

namespace App\Product\Command\ListProducts\Request;

use App\Product\Command\ListProducts\Response\ListProductResponse;
use App\Product\Entity\ProductRepository;

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
