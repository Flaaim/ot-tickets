<?php

namespace App\Product\ArchiveProduct\Request;

use App\Product\ArchiveProduct\Response\Response;
use App\Product\Entity\ProductRepository;
use App\Shared\Domain\ValueObject\Id;

class Handler
{
    private ProductRepository $products;

    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    public function handle(Command $command): Response
    {
        $product = $this->products->get(new Id($command->productId));

        $product->archive();

        $this->products->save($product);

        return new Response($product->getId()->getValue());
    }
}
