<?php

namespace App\Auth\Entity;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class StatusType extends StringType
{
    const NAME = 'auth_user_status';
    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof Status ? $value->getName() : $value;
    }
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?Status
    {
        return !empty($value) ? new Status((string)$value) : null;
    }
    public function getName(): string
    {
        return self::NAME;
    }
}
