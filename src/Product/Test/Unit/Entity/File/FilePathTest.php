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
    private FilePath $filePath;
    private UploadDirectory $uploadDirectory;
    private FullName $fullName;

    private string $testFilePath;
    public function setUp(): void
    {
        $this->filePath = new FilePath(
            $this->uploadDirectory = $this->getUploadDirectory(),
            $this->fullName = $this->getFullName()
        );
        $this->testFilePath = $this->uploadDirectory->getUploadDirectory().'/'.$this->fullName->getValue();
    }

    public function testSuccess(): void
    {
        $this->assertNotNull($this->filePath->getValue());
        $this->assertEquals($this->testFilePath, $this->filePath->getValue());
    }

    public function testIsFileExists(): void
    {
        file_put_contents($this->testFilePath, 'test content');
        $this->assertTrue($this->filePath->isFileExists());
    }

    public function testIsFileNotExists(): void
    {
        file_put_contents($this->testFilePath, 'test content');
        unlink($this->testFilePath);
        $this->assertFalse($this->filePath->isFileExists());
    }

    public function testDeleteSuccess(): void
    {
        file_put_contents($this->testFilePath, 'test content');
        $this->filePath->deleteFile();
        $this->assertFalse($this->filePath->isFileExists());
    }

    public function testDeleteFileNotFound(): void
    {
        $this->expectException(\DomainException::class);
        $this->filePath->deleteFile();
    }

    public function tearDown(): void
    {
        if (file_exists($this->testFilePath)) {
            unlink($this->testFilePath);
        }
    }


    private function getUploadDirectory(): UploadDirectory
    {
        return new UploadDirectory(
            sys_get_temp_dir(),
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
