<?php

namespace App\Product\SearchProduct\Request;

use App\Product\Entity\ProductRepository;
use App\Product\SearchProduct\Response\SearchProductResponse;
use DomainException;


class Handler
{
    private ProductRepository $products;
    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }
    public function handle(Command $command): SearchProductResponse
    {
        $product = $this->products->findByQuery($command->query);

        if(null === $product){
            throw new DomainException("Product not found");
        }

        return SearchProductResponse::fromProduct($product);
    }
}
