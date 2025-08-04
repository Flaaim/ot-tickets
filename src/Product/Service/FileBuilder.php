<?php

namespace App\Product\Service;

use App\Product\Entity\File;
use App\Product\Entity\File\FileExtension;
use App\Product\Entity\File\FileName;
use App\Product\Entity\File\FilePath;
use App\Product\Entity\File\FileSize;
use App\Product\Entity\File\FullName;
use App\Product\Entity\File\UploadDirectory;
use Ramsey\Uuid\Uuid;
use Slim\Psr7\UploadedFile;

final class FileBuilder
{
    public function __construct(
        private MimeTypeMapper $mimeTypeMapper
    ) {}

    public function buildFromUploadFile(UploadedFile $file, UploadDirectory $directory): File
    {
        $filename = new FileName(Uuid::uuid4()->toString());
        $fileSize = new FileSize($file->getSize());
        $fileExtension = (new FileExtensionFromMime(
            $file->getClientMediaType(),
            $this->mimeTypeMapper,
        ))->getFileExtensionFromMime();

        $filePath = new FilePath(
            $directory,
            new FullName($filename, $fileExtension)
        );

        return new File(
            $filename,
            $fileExtension,
            $filePath,
            $fileSize,
        );
    }
}
