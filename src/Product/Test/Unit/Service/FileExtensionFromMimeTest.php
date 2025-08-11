<?php

namespace App\Product\Test\Unit\Service;

use App\Product\Entity\File\FileExtension;
use App\Product\Service\FileExtensionFromMime;
use App\Product\Service\MimeTypeMapper;
use PHPUnit\Framework\TestCase;

class FileExtensionFromMimeTest extends TestCase
{
    public function testSuccess(): void
    {
        $fileExtensionFromMime = new FileExtensionFromMime(
            'application/msword',
            $this->getMimeTypeMapper()
        );

        $this->assertNotNull($fileExtensionFromMime->getFileExtensionFromMime());
        $this->assertInstanceOf(FileExtension::class, $fileExtensionFromMime->getFileExtensionFromMime());
    }

    public function testNotExists(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new FileExtensionFromMime(
            'application/pdf',
            $this->getMimeTypeMapper()
        );
    }
    public function testEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new FileExtensionFromMime(
            '',
            $this->getMimeTypeMapper()
        );
    }


    private function getMimeTypeMapper(): MimeTypeMapper
    {
        $mimeTypes = [
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx'
        ];
        return new MimeTypeMapper($mimeTypes);
    }
}
