<?php

namespace App\Product\Test\Unit\Entity\File;

use App\Product\Entity\File\FileName;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class FileNameTest extends TestCase
{
    public function testSuccess(): void
    {
        $filename = new FileName($value = Uuid::uuid4()->toString());

        self::assertNotNull($filename->getValue());
        self::assertEquals($value, $filename->getValue());
    }

    public function testInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new FileName('invalidFilename');
    }

    public function testEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new FileName('');
    }

    public function testCase(): void
    {
        $value = Uuid::uuid4()->toString();
        $filename = new FileName(mb_strtoupper($value));

        self::assertEquals($value, $filename->getValue());
    }
}
