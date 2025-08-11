<?php

namespace App\Product\Command\CreateProduct\Request;

use App\Product\Command\CreateProduct\Response\Response;
use App\Product\Entity\File;
use App\Product\Entity\File\UploadDirectory;
use App\Product\Entity\Price;
use App\Product\Entity\Product;
use App\Product\Entity\ProductRepository;
use App\Product\Entity\Status;
use App\Product\Service\FileBuilder;
use App\Product\Service\MimeTypeMapper;
use App\Product\Service\Uploader;
use App\Shared\Domain\ValueObject\Id;
use DateTimeImmutable;
use Slim\Psr7\UploadedFile;

class Handler
{
    private ProductRepository $products;
    private UploadDirectory $uploadDirectory;
    private MimeTypeMapper $mimeTypeMapper;
    public function __construct(
        ProductRepository $products,
        UploadDirectory $uploadDirectory,
        MimeTypeMapper $mimeTypeMapper
    )
    {
        $this->products = $products;
        $this->uploadDirectory = $uploadDirectory;
        $this->mimeTypeMapper = $mimeTypeMapper;

    }

    public function handle(Command $command): Response
    {
        $product = new Product(
            $id = Id::generate(),
            $command->name,
            $command->description,
            new Price($command->price),
            $command->cipher,
            new DateTimeImmutable(),
            Status::archive(),
            null
        );

        if($command->uploadedFile !== null) {
            $file = $this->handleUpload($command->uploadedFile, $product);
            $product->addFile($file);
        }

        $this->products->save($product);

        return new Response(
            $product->getId()->getValue(),
            $product->getName(),
            $product->getPrice()->getValue(),
        );
    }

    private function handleUpload(UploadedFile $uploadedFile, Product $product): File
    {
        $builder = new FileBuilder($this->mimeTypeMapper);

        $uploader = new Uploader($builder);

        return $uploader->upload($uploadedFile, $this->uploadDirectory, $product);
    }
}
