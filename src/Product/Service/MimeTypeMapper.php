<?php

namespace App\Product\Service;

use Doctrine\DBAL\Exception\InvalidArgumentException;
use Webmozart\Assert\Assert;

class MimeTypeMapper
{
    private array $mimeToExtensionMap;
    public function __construct(array $mimeToExtensionMap)
    {
        Assert::notEmpty($mimeToExtensionMap);
        Assert::allString($mimeToExtensionMap);
        $this->mimeToExtensionMap = $mimeToExtensionMap;
    }

    public function getAll(): array
    {
        return $this->mimeToExtensionMap;
    }
    public function getExtensionByMimeType(string $mimeType): string
    {
        if(!isset($this->mimeToExtensionMap[$mimeType])) {
            throw new InvalidArgumentException('Invalid mime type: ' . $mimeType);
        }
        return $this->mimeToExtensionMap[$mimeType];
    }
}
