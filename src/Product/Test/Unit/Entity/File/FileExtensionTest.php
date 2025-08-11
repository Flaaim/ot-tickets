<?php

namespace App\Product\Test\Unit\Entity\File;

use App\Product\Entity\File\FileExtension;
use App\Product\Service\FileExtensionFromMime;
use PHPUnit\Framework\TestCase;

class FileExtensionTest extends TestCase
{
    public function testSuccess(): void
    {
        $fileExtension = new FileExtension($value = 'doc');
        $this->assertEquals($value, $fileExtension->getValue());
        $this->assertNotNull($fileExtension->getValue());
    }

    public function testEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new FileExtension('');
    }
}
