<?php

namespace App\Product\Entity;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\FloatType;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Type;


class PriceType extends StringType
{
    public const NAME = 'price';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof Price ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Price
    {
        return !empty($value) ? new Price((float)$value) : null;
    }
    public function getName(): string
    {
        return self::NAME;
    }
}
