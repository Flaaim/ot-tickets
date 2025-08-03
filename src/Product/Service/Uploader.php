<?php

namespace App\Product\Service;

use App\Product\Entity\File;
use App\Product\Entity\File\FileName;
use App\Product\Entity\File\FilePath;
use App\Product\Entity\File\FileSize;
use App\Product\Entity\File\FullName;
use Ramsey\Uuid\Uuid;
use Slim\Psr7\UploadedFile;

class Uploader
{
    private File\UploadDirectory $uploadDirectory;
    private MimeTypeMapper $mimeTypeMapper;
    public function __construct(
        File\UploadDirectory $uploadDirectory,
        MimeTypeMapper $mimeTypeMapper
    ){
        $uploadDirectory->ensureExists();
        $this->uploadDirectory = $uploadDirectory;
    }
    public function upload(UploadedFile $uploadedFile): File
    {

        if($uploadedFile->getError() === UPLOAD_ERR_OK) {

            $fileExtensionFromMine = new FileExtensionFromMime($uploadedFile->getClientMediaType(), $this->mimeTypeMapper);
            $fullName = new FullName(
                $filename = new FileName(Uuid::uuid4()->toString()),
                $extension = $fileExtensionFromMine->getFileExtensionFromMime()
            );

            $filePath = new FilePath($this->uploadDirectory, $fullName);
            $size = new FileSize($uploadedFile->getSize());

            $uploadedFile->moveTo($filePath->getValue());

            return new File(
                $filename,
                $extension,
                $filePath,
                $size,
            );
        }

    }

    public function rollback(File $file): void
    {
        if(file_exists($file->getPath())) {
            unlink($file->getPath());
        }
    }
}
