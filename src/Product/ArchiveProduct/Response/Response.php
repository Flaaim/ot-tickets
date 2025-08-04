<?php

namespace App\Product\ArchiveProduct\Response;

use Webmozart\Assert\Assert;

class Response
{
    public function __construct(
        private readonly string $productId
    )
    {}
}
