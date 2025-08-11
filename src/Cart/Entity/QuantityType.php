<?php

namespace App\Cart\Entity;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\StringType;

class QuantityType extends GuidType
{
    public const NAME = 'quantity';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof Quantity ? $value->getValue() : $value;
    }
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Quantity
    {
        return !empty($value) ? new Quantity((int)$value) : null;
    }
    public function getName(): string
    {
        return self::NAME;
    }
}
