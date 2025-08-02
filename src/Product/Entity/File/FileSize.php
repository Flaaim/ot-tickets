<?php

namespace App\Product\Entity\File;

use Webmozart\Assert\Assert;

class FileSize
{
    private int $value;
    public function __construct(int $value)
    {
        Assert::lessThanEq($value, 15 * 1024 * 1024, 'File too large');
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
