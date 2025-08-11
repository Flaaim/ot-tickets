<?php

namespace App\Cart\Command\GetCart\Response;

class Response
{
    public function __construct(
        private readonly string $id,
        private readonly array $products
    ){}
}
