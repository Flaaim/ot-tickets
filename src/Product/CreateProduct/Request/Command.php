<?php

namespace App\Product\CreateProduct\Request;

use DateTimeImmutable;
use Webmozart\Assert\Assert;

class Command
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly float $price,
        public readonly string $cipher
    ) {
        Assert::minLength($name, 3);
        Assert::minLength($description, 10);
        Assert::greaterThan($price, 0);
        Assert::regex($cipher, '/^[A-Z0-9-]+$/');
    }
}
