<?php

namespace App\Product\Entity\File;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class FileExtensionType extends StringType
{
    public const NAME = 'file_extension';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof FileExtension ? $value->getValue() : $value;
    }
    public function convertToPHPValue($value, AbstractPlatform $platform): ?FileExtension
    {
        return !empty($value) ? new FileExtension((string)$value) : null;
    }
    public function getName(): string
    {
        return self::NAME;
    }
}
