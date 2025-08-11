<?php

namespace App\Product\Entity\File;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class FileNameType extends StringType
{
    public const NAME = 'file_name';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof FileName ? $value->getValue() : $value;
    }
    public function convertToPHPValue($value, AbstractPlatform $platform): ?FileName
    {
        return !empty($value) ? new FileName((string)$value) : null;
    }
    public function getName(): string
    {
        return self::NAME;
    }
}
