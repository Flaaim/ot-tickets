<?php

namespace App\Product\UploadProduct\Response;

class Response
{
    public function __construct(
        public readonly string $id,
        public readonly string $status = 'success'
    ){}
}
