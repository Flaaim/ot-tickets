<?php

namespace App\Cart\Add\Response;

use App\Cart\Entity\Cart;
use ArrayObject;

class Response
{
    public function __construct(
        private readonly string $id,
        private readonly array $products,
    )
    {}
}
