<?php

namespace App\Auth\Entity;

use Webmozart\Assert\Assert;

class Role
{
    public const USER = 'user';
    public const ADMIN = 'admin';
    private string $name;
    public function __construct(string $role)
    {
        Assert::oneOf($role, [
            self::USER,
            self::ADMIN]
        );
        $this->name = $role;
    }
    public static function user(): self
    {
        return new self(self::USER);
    }
    public function getName(): string
    {
        return $this->name;
    }
}
