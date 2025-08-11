<?php

namespace App\Product\Command\GetProductDetails\Request;

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
