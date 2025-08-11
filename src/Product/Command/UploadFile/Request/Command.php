<?php

namespace App\Product\UploadFile\Request;

use Slim\Psr7\UploadedFile;
use Webmozart\Assert\Assert;

class Command
{
    public function __construct(
        public readonly string $productId,
        public readonly UploadedFile $uploadedFile
    ){
        Assert::uuid($this->productId, 'Invalid product ID format');
    }

}
