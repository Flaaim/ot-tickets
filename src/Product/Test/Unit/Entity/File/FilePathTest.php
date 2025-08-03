<?php

namespace App\Product\Test\Unit\Entity\File;

use App\Product\Entity\File\FileExtension;
use App\Product\Entity\File\FileName;
use App\Product\Entity\File\FilePath;
use App\Product\Entity\File\FileSystem;
use App\Product\Entity\File\FullName;
use App\Product\Entity\File\UploadDirectory;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class FilePathTest extends TestCase
{
    public function testSuccess(): void
    {
        $filePath = new FilePath(
            $uploadDirectory = $this->getUploadDirectory(),
            $fullName = $this->getFullName()
        );
        $value = $uploadDirectory->getUploadDirectory(). '/' . $fullName->getValue();
        $this->assertNotNull($filePath->getValue());
        $this->assertEquals($value, $filePath->getValue());
    }

    private function getUploadDirectory(): UploadDirectory
    {
        return new UploadDirectory(
            'some/upload/directory',
            new FileSystem()
        );
    }

    private function getFullName(): FullName
    {
        return new FullName(
            new FileName(Uuid::uuid4()->toString()),
            new FileExtension('docx')
        );
    }
}
