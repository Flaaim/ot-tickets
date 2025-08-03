<?php

namespace App\Product\Service;

use App\Product\Entity\File\FileExtension;
use Webmozart\Assert\Assert;

class FileExtensionFromMime
{
    private MimeTypeMapper $mimeType;
    private string $value;
    public function __construct(string $value, MimeTypeMapper $mimeTypeMapper)
    {
        Assert::keyExists(
            $mimeTypeMapper->getAll(),
            $value
        );
        $this->value = $mimeTypeMapper->getExtensionByMimeType($value);
    }
    public function getFileExtensionFromMime(): FileExtension
    {
        return new FileExtension($this->value);
    }

}
