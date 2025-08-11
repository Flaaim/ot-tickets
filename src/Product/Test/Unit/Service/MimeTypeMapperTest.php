<?php

namespace App\Product\Test\Unit\Service;

use App\Product\Service\MimeTypeMapper;
use PHPUnit\Framework\TestCase;

class MimeTypeMapperTest extends TestCase
{
    public function testSuccess(): void
    {
        $mimeTypes = [
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx'
        ];
        $mimeTypeMapper = new MimeTypeMapper($mimeTypes);
        $this->assertIsArray($mimeTypeMapper->getAll());
        $this->assertSame($mimeTypes, $mimeTypeMapper->getAll());

    }

    public function testNonStringValues(): void
    {
        $mimeTypes = [
            2 => 1,
            3 => 4
        ];
        $this->expectException(\InvalidArgumentException::class);
        new MimeTypeMapper($mimeTypes);
    }

    public function testEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new MimeTypeMapper([]);
    }

    public function testGetExtensionSuccess(): void
    {
        $mimeTypes = [
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx'
        ];
        $mimeTypeMapper = new MimeTypeMapper($mimeTypes);

        $extension = $mimeTypeMapper->getExtensionByMimeType($value = 'application/msword');

        $this->assertIsString($extension);
        $this->assertSame($mimeTypes[$value], $extension);
    }

    public function testGetExtensionFail(): void
    {
        $mimeTypes = [
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx'
        ];
        $mimeTypeMapper = new MimeTypeMapper($mimeTypes);

        $this->expectException(\InvalidArgumentException::class);
        $mimeTypeMapper->getExtensionByMimeType('application/pdf');
    }
}
