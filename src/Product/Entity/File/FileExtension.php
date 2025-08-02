<?php

namespace App\Product\Entity\File;

use Webmozart\Assert\Assert;

class FileExtension
{
    const MimeTypes = [
        'application/msword' => 'doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx'
    ];

    private string $value;
    public function __construct(string $mimeType)
    {
        Assert::keyExists(self::MimeTypes, $mimeType);
        $this->value = $this->getExtensionFromMime($mimeType);
    }
    private function getExtensionFromMime(string $mimeType): string
    {
        return self::MimeTypes[$mimeType];
    }
    public function getValue(): string
    {
        return $this->value;
    }
}
