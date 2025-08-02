<?php

namespace App\Product\Test\Unit\Entity\File;

use App\Product\Entity\File\FileSystem;
use App\Product\Entity\File\UploadDirectory;
use PHPUnit\Framework\TestCase;


class UploadDirectoryTest extends TestCase
{
    public function testSuccess(): void
    {
        $uploadDirectory = new UploadDirectory($value = 'some/path', $fileSystem = $this->getFileSystem());

        $this->assertNotNull($uploadDirectory->getUploadDirectory());
        $this->assertEquals($value, $uploadDirectory->getUploadDirectory());
    }

    public function testEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new UploadDirectory('', $fileSystem = $this->getFileSystem());
    }

    public function testEnsureFailed(): void
    {
        $uploadDirectory = new UploadDirectory(
            $value = 'some/path',
            $fileSystem = $this->getFileSystem()
        );

        $fileSystem->method('isDirectory')->willReturn(false);
        $fileSystem->method('makeDirectory')->willReturn(false);

        $this->expectException(\RuntimeException::class);
        $uploadDirectory->ensureExists();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testEnsureSuccess(): void
    {
        $uploadDirectory = new UploadDirectory(
            $value = 'some/path',
            $fileSystem = $this->getFileSystem()
        );

        $fileSystem->method('isDirectory')->willReturn(true);
        $fileSystem->method('makeDirectory')->willReturn(true);

        $uploadDirectory->ensureExists();
    }
    private function getFileSystem(): FileSystem
    {
        return $this->createStub(FileSystem::class);
    }

}
