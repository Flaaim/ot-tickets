<?php

namespace App\Product\Command\UploadFile\Request;

use App\Product\Entity\File\UploadDirectory;
use App\Product\Entity\ProductRepository;
use App\Product\Service\FileBuilder;
use App\Product\Service\MimeTypeMapper;
use App\Product\Service\Uploader;
use App\Product\UploadProduct\Response\Response;
use App\Shared\Domain\ValueObject\Id;

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
        $this->uploadDirectory = $uploadDirectory;
        $this->mimeTypeMapper = $mimeTypeMapper;
        $this->products = $products;
    }

    public function handle(Command $command): Response
    {
        $product = $this->products->get(new Id($command->productId));

        $builder = new FileBuilder($this->mimeTypeMapper);

        $uploader = new Uploader($builder);

        $file = $uploader->upload($command->uploadedFile, $this->uploadDirectory, $product);

        $product->addFile($file);

        try{
            $this->products->save($product);
        }catch (\Throwable $e){
            $uploader->rollback($file);
            throw $e;
        }

        return new Response($product->getId()->getValue());
    }
}
