<?php

namespace App\Product\Entity\File;

use Webmozart\Assert\Assert;

class FileName
{
    private string $value;
    public function __construct(string $filename)
    {
        Assert::uuid($filename);
        $this->value = mb_strtolower($filename);
    }
    public function getValue(): string
    {
        return $this->value;
    }
}
