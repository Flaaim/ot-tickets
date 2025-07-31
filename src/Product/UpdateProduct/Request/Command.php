<?php

namespace App\Product\UpdateProduct\Request;

use Webmozart\Assert\Assert;

class Command
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $name = null,
        public readonly ?string $description = null,
        public readonly ?string $price = null,
        public readonly ?string $cipher = null,

    ){
        Assert::uuid($this->id);
        Assert::nullOrLengthBetween($name, 3, 255);
        Assert::nullOrGreaterThan($price, 0);
    }
}
