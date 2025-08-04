<?php

namespace App\Product\ArchiveProduct\Request;

use Webmozart\Assert\Assert;

class Command
{
    public function __construct(
        public readonly string $productId,
        public readonly string $reason
    )
    {
        Assert::uuid($productId);
        Assert::minLength($reason, 10);
    }
}
