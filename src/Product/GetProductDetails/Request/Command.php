<?php

namespace App\Product\GetProductDetails\Request;

use App\Product\Entity\Product;
use Webmozart\Assert\Assert;

class Command
{
    public function __construct(
        public readonly string $id
    )
    {
        Assert::uuid($this->id);
    }
}
