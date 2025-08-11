<?php

namespace App\Product\Entity\File;

use DateInterval;
use Webmozart\Assert\Assert;

class FileExtension
{
    private string $value;
    public function __construct(string $extension)
    {
        Assert::notEmpty($extension);
        $this->value = $extension;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
