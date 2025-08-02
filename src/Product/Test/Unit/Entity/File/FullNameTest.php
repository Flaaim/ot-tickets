<?php

namespace App\Product\Test\Unit\Entity\File;

use App\Product\Entity\File\FileExtension;
use App\Product\Entity\File\FileName;
use App\Product\Entity\File\FullName;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class FullNameTest extends TestCase
{
    public function testSuccess(): void
    {
        $fullName = new FullName(
            $filename = $this->getFilename(),
            $extension = $this->getFileExtension()
        );
        $value = $filename->getValue() . '.' . $extension->getValue();

        $this->assertNotNull($fullName->getValue());
        $this->assertEquals($value, $fullName->getValue());

        $this->assertEquals($extension->getValue(), $fullName->getExtension());
        $this->assertEquals($filename->getValue(), $fullName->getName());
    }


    private function getFilename(): FileName
    {
        return new FileName(Uuid::uuid4()->toString());
    }
    private function getFileExtension(): FileExtension
    {
        return new FileExtension('application/msword');
    }
}
