<?php

namespace App\Cart\GetCart\Response;

use App\Cart\Entity\Cart;

class Response
{
    public function __construct(
        private readonly string $id,
        private readonly array $products
    ){}
}
