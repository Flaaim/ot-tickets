<?php

namespace App\Product\Service;

use Webmozart\Assert\Assert;

class MimeTypeMapper
{
    private array $mimeToExtensionMap;
    public function __construct(array $mimeToExtensionMap)
    {
        Assert::allString($mimeToExtensionMap);
        $this->mimeToExtensionMap = $mimeToExtensionMap;
    }

    public function getAll(): array
    {
        return $this->mimeToExtensionMap;
    }
    public function getExtensionByMimeType(string $mimeType): string
    {
        return $this->mimeToExtensionMap[$mimeType];
    }
}
