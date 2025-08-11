<?php

namespace App\Product\Service;

use App\Product\Entity\File;
use App\Product\Entity\File\FileExtension;
use App\Product\Entity\File\FileName;
use App\Product\Entity\File\FilePath;
use App\Product\Entity\File\FileSize;
use App\Product\Entity\File\FullName;
use App\Product\Entity\File\UploadDirectory;
use App\Product\Entity\Product;
use App\Shared\Domain\ValueObject\Id;
use Ramsey\Uuid\Uuid;
use Slim\Psr7\UploadedFile;

final class FileBuilder
{
    public function __construct(
        private MimeTypeMapper $mimeTypeMapper
    ) {}

    public function buildFromUploadFile(UploadedFile $file, UploadDirectory $directory, Product $product): File
    {
        $filename = new FileName(Uuid::uuid4()->toString());
        $fileSize = new FileSize($file->getSize());
        $fileExtension = (new FileExtensionFromMime(
            $file->getClientMediaType(),
            $this->mimeTypeMapper,
        ))->getFileExtensionFromMime();

        $fullFilePath = $directory->getUploadDirectory().
            DIRECTORY_SEPARATOR.
            (new FullName($filename, $fileExtension))->getValue();

        $filePath = new FilePath($fullFilePath);

        return new File(
            ID::generate(),
            $filename,
            $fileExtension,
            $filePath,
            $fileSize,
            $product,
        );
    }
}
