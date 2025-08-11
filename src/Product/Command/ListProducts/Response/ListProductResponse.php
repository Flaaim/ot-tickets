<?php

namespace App\Product\Command\ListProducts\Response;

use App\Product\Entity\PaginatedResults;

class ListProductResponse
{
    private PaginatedResults $paginatedResults;
    public function __construct(PaginatedResults $paginatedResults)
    {
        $this->paginatedResults = $paginatedResults;
    }
}
