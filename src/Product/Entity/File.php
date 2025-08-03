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

}
