<?php

namespace App\Product\Entity\File;

class FilePath
{
    private string $value;

    public function __construct(UploadDirectory $uploadDirectory, Fullname $fullName){

        $this->value = $uploadDirectory->getUploadDirectory() . '/' . $fullName->getValue();
    }
    public function getValue(): string
    {
        return $this->value;
    }

    public function isFileExists(): bool
    {
        return file_exists($this->value);
    }

}
