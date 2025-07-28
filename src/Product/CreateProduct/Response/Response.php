<?php

namespace App\Product\CreateProduct\Response;

use App\Product\Entity\Product;

class Response
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly float $formattedPrice
    ) {}
}
