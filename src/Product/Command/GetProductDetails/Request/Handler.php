<?php

namespace App\Product\Command\GetProductDetails\Request;

use App\Product\Command\GetProductDetails\Response\ProductDetailsResponse;
use App\Product\Entity\ProductRepository;
use App\Shared\Domain\ValueObject\Id;

class Handler
{
    private ProductRepository $products;
    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    public function handle(Command $command): ProductDetailsResponse
    {
        $product = $this->products->get(new Id($command->id));

        return ProductDetailsResponse::fromProduct($product);
    }
}
