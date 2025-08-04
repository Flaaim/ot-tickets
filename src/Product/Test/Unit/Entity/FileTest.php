<?php

namespace App\Product\Test\Unit\Entity;

use App\Product\Entity\File;
use App\Product\Entity\File\FileExtension;
use App\Product\Entity\File\FileName;
use App\Product\Entity\File\FilePath;
use App\Product\Entity\File\FileSize;
use PHPUnit\Framework\TestCase;


class FileTest extends TestCase
{

    public function testSuccess(): void
    {
        $file = new File(
            $filename = $this->createMock(FileName::class),
            $fileExtension = $this->createMock(FileExtension::class),
            $filePath = $this->createMock(FilePath::class),
            $fileSize = $this->createMock(FileSize::class),
        );

        $this->assertSame($file->getFilename(), $filename->getValue());
        $this->assertSame($file->getExtension(), $fileExtension->getValue());
        $this->assertSame($file->getPath(), $filePath->getValue());
        $this->assertSame($file->getSize(), $fileSize->getValue());
    }

}
