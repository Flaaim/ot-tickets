<?php

namespace App\Product\UpdateProduct\Request;

use App\Product\Entity\Price;
use App\Product\Entity\ProductRepository;
use App\Product\UpdateProduct\Response\Response;
use App\Shared\Domain\ValueObject\Id;

class Handler
{
    private ProductRepository $products;
    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    public function __handle(Command $command): Response
    {
        $product = $this->products->get(new Id($command->id));

        if($command->name !== null) {
            $product->changeName($command->name);
        }

        if($command->description !== null) {
            $product->changeDescription($command->description);
        }

        if($command->price !== null) {
            $product->changePrice(new Price($command->price));
        }
        if($command->cipher !== null) {
            $product->changeCipher($command->cipher);
        }

        $this->products->save($product);
        
        return new Response($product->getId()->getValue());
    }
}
