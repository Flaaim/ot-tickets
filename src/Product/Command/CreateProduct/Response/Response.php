<?php

namespace App\Product\Command\CreateProduct\Response;

class Response
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly float $formattedPrice
    ) {}
}
