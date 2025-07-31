<?php

namespace App\Product\UpdateProduct\Response;

class Response
{
    public function __construct(
        public readonly string $id,
        public readonly string $status = 'success'
    )
    {}
}
