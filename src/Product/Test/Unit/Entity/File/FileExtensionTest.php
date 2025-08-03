<?php

namespace App\Product\Test\Unit\Entity\File;

use App\Product\Service\FileExtensionFromMime;
use PHPUnit\Framework\TestCase;

class FileExtensionTest extends TestCase
{
    public function testSuccess(): void
    {
        $mimeTypes = [
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx'
        ];
        $fileExtension = new FileExtensionFromMime($value = 'application/msword');

        $this->assertEquals($mimeTypes[$value], $fileExtension->getValue());
        $this->assertNotNull($fileExtension->getValue());

        $fileExtension = new FileExtensionFromMime($value = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');

        $this->assertEquals($mimeTypes[$value], $fileExtension->getValue());
    }

    public function testInvalidExtension(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new FileExtensionFromMime('application/pdf');
    }

    public function testInvalidEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new FileExtensionFromMime('');
    }
}
