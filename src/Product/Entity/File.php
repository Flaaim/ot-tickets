<?php

namespace App\Product\Entity;


use App\Product\Entity\File\FileExtension;
use App\Product\Entity\File\FileName;
use App\Product\Entity\File\FilePath;
use App\Product\Entity\File\FileSize;

class File
{
    private FileName $filename;
    private FilePath $path;
    private FileExtension $extension;
    private FileSize $size;
    public function __construct(FileName $filename, FileExtension $extension, FilePath $path, FileSize $size)
    {
        $this->filename = $filename;
        $this->path = $path;
        $this->extension = $extension;
        $this->size = $size;
    }
    public function getPath(): string
    {
        return $this->path->getValue();
    }
    public function getFilename(): string
    {
        return $this->filename->getValue();
    }
    public function getExtension(): string
    {
        return $this->extension->getValue();
    }
    public function getSize(): int
    {
        return $this->size->getValue();
    }
    public function isFileExists(): bool
    {
        return $this->path->isFileExists();
    }
    public function deleteFile(): void
    {
        try {
            if ($this->isFileExists()) {
                unlink($this->getPath());
            }
        } catch (\Throwable $e) {
            throw new \RuntimeException('Failed to delete file: ' . $this->getPath(), 0, $e);
        }
    }
}
