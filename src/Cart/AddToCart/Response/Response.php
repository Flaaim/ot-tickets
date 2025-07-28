<?php

namespace App\Cart\AddToCart\Response;


class Response
{
    public function __construct(
        private readonly string $id,
        private readonly array $products,
    )
    {}
}
