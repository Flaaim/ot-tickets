<?php

namespace App\Product\Test\Unit\Entity\File;

use App\Product\Entity\File\FileSize;
use PHPUnit\Framework\TestCase;


class FileSizeTest extends TestCase
{
    public function testSuccess(): void
    {
        $fileSize = new FileSize($value = 1);
        $this->assertNotNull($fileSize->getValue());
        $this->assertEquals($value, $fileSize->getValue());
    }

    public function testLarge(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new FileSize(16 * 1024 * 1024);
    }
}
