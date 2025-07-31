<?php

namespace App\Product\ListProducts\Response;

use App\Product\Entity\PaginatedResults;
use ArrayObject;

class ListProductResponse
{
    private PaginatedResults $paginatedResults;
    public function __construct(PaginatedResults $paginatedResults)
    {
        $this->paginatedResults = $paginatedResults;
    }
}
