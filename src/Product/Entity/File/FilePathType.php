<?php

namespace App\Product\Entity\File;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class FilePathType extends StringType
{
    public const NAME = 'file_path';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof FilePath ? $value->getValue() : $value;
    }


    public function convertToPHPValue($value, AbstractPlatform $platform): ?FilePath
    {
        return !empty($value) ? new FilePath((string)($value)) : null;
    }
    public function getName(): string
    {
        return self::NAME;
    }
}
