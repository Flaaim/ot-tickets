<?php

namespace App\Auth\Entity;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class RoleType extends StringType
{
    const NAME = 'auth_user_role';

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): mixed
    {
       return $value instanceof Role ? $value->getName() : $value;
    }
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Role
    {
        return !empty($value) ? new Role((string)$value) : null;
    }
    public function getName(): string
    {
        return self::NAME;
    }
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
