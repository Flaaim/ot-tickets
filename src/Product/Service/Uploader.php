<?php

namespace App\Product\Service;

use App\Product\Entity\File;
use App\Product\Entity\File\UploadDirectory;
use App\Product\Entity\Product;
use Slim\Psr7\UploadedFile;

class Uploader
{
    private FileBuilder $fileBuilder;
    public function __construct(FileBuilder $fileBuilder){
        $this->fileBuilder = $fileBuilder;
    }
    public function upload(UploadedFile $file, UploadDirectory $directory, Product $product): File
    {
        if ($file->getError() !== UPLOAD_ERR_OK) {
            throw new \RuntimeException('Upload error: ' . $file->getError());
        }

        $fileObj = $this->fileBuilder->buildFromUploadFile($file, $directory, $product);

        $file->moveTo($fileObj->getPath());

        return $fileObj;
    }
    public function rollback(File $file): void
    {
        if(file_exists($file->getPath())) {
            unlink($file->getPath());
        }
    }
}
