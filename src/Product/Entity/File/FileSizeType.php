<?php

namespace App\Product\Entity\File;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class FileSizeType extends GuidType
{
    public const NAME = 'file_size';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof FileSize ? $value->getValue() : $value;
    }
    public function convertToPHPValue($value, AbstractPlatform $platform): ?FileSize
    {
        return !empty($value) ? new FileSize((int)$value) : null;
    }
    public function getName(): string
    {
        return self::NAME;
    }
}
