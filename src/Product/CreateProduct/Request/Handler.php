<?php

namespace App\Product\CreateProduct\Request;

use App\Product\CreateProduct\Response\Response;
use App\Product\Entity\Price;
use App\Product\Entity\Product;
use App\Product\Entity\ProductRepository;
use App\Product\Entity\Status;
use App\Shared\Domain\ValueObject\Id;
use DateTimeImmutable;
use Slim\Psr7\UploadedFile;

class Handler
{
    private ProductRepository $products;
    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    public function handle(Command $command): Response
    {
        $product = new Product(
            Id::generate(),
            $command->name,
            $command->description,
            new Price($command->price),
            $command->cipher,
            new DateTimeImmutable(),
            Status::archive(),
            $command->uploadedFile ?? null
        );

        $this->products->save($product);

        return new Response(
            $product->getId()->getValue(),
            $product->getName(),
            $product->getPrice()->getValue(),
        );
    }
}
