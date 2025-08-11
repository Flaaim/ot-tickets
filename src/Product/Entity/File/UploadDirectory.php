<?php

namespace App\Product\Entity\File;

use Webmozart\Assert\Assert;

final class UploadDirectory
{
    private string $uploadDirectory;
    private FileSystem $fileSystem;
    public function __construct(string $uploadDirectory, FileSystem $fileSystem){
        Assert::notEmpty($uploadDirectory, 'Upload directory cannot be empty');
        $this->uploadDirectory = $uploadDirectory;
        $this->fileSystem = $fileSystem;
    }

    public function ensureExists(): void
    {
        if (!$this->fileSystem->isDirectory($this->uploadDirectory)
            && !$this->fileSystem->makeDirectory($this->uploadDirectory)
        ) {
            throw new \RuntimeException("Failed to create directory: {$this->uploadDirectory}");
        }
    }


    public function getUploadDirectory(): string
    {
        return $this->uploadDirectory;
    }
}
