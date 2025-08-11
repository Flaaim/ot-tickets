<?php

namespace App\Product\Command\ArchiveProduct\Response;

class Response
{
    public function __construct(
        private readonly string $productId
    )
    {}
}
