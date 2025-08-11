<?php

namespace App\Product\Command\SearchProduct\Request;

use Webmozart\Assert\Assert;

class Command
{
    public function __construct(public readonly string $query){
        Assert::notEmpty($query);
        Assert::minLength($query, 3);
    }
}
